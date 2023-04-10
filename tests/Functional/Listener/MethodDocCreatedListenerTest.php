<?php
namespace Tests\Functional\Endpoint;

use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints\Type;
use Yoanm\JsonRpcParamsSymfonyConstraintDoc\Infra\Transformer\ConstraintToParamsDocTransformer;
use Yoanm\JsonRpcParamsSymfonyValidator\Domain\MethodWithValidatedParamsInterface;
use Yoanm\JsonRpcServer\Domain\JsonRpcMethodInterface;
use Yoanm\JsonRpcServerDoc\Domain\Model\MethodDoc;
use Yoanm\JsonRpcServerDoc\Domain\Model\Type\StringDoc;
use Yoanm\SymfonyJsonRpcHttpServerDoc\Event\MethodDocCreatedEvent;
use Yoanm\SymfonyJsonRpcParamsSfConstraintsDoc\Listener\MethodDocCreatedListener;

/**
 * @covers \Yoanm\SymfonyJsonRpcParamsSfConstraintsDoc\Listener\MethodDocCreatedListener
 */
class MethodDocCreatedListenerTest extends TestCase
{
    use ProphecyTrait;

    /** @var MethodDocCreatedListener */
    private $listener;

    /** ConstraintToParamsDocTransformer|ObjectProphecy */
    private $paramDocConverter;

    protected function setUp(): void
    {
        $this->paramDocConverter = $this->prophesize(ConstraintToParamsDocTransformer::class);

        $this->listener = new MethodDocCreatedListener(
            $this->paramDocConverter->reveal()
        );
    }

    public function testShouldDoNothingIfMethodDoesImplementRightInterface()
    {
        $methodDoc = new MethodDoc('name');
        $event = new MethodDocCreatedEvent($methodDoc);
        $method = new class implements JsonRpcMethodInterface {
            public function apply(array $paramList = null)
            {
                return null;
            }
        };
        $event->setMethod($method);

        $this->paramDocConverter->transform(Argument::cetera())
            ->shouldNotBeCalled()
        ;

        $this->listener->enhanceMethodDoc($event);

        $this->assertNull($methodDoc->getParamsDoc());
    }

    public function testShouldAppendParamsDocIfMethodImplementsRightInterface()
    {
        $methodDoc = new MethodDoc('name');
        $event = new MethodDocCreatedEvent($methodDoc);
        $method = new class implements JsonRpcMethodInterface, MethodWithValidatedParamsInterface {
            public function apply(array $paramList = null)
            {
                return null;
            }

            public function getParamsConstraint(): Constraint
            {
                return new Type('string');
            }

        };
        $event->setMethod($method);
        $expectedDoc = new StringDoc();

        $this->paramDocConverter->transform($method->getParamsConstraint())
            ->willReturn($expectedDoc)
            ->shouldBeCalled()
        ;

        $this->listener->enhanceMethodDoc($event);

        $this->assertSame($expectedDoc, $methodDoc->getParamsDoc());
    }
}
