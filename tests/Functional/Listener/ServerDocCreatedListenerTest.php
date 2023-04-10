<?php
namespace Tests\Functional\Endpoint;

use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Yoanm\JsonRpcServer\Domain\Exception\JsonRpcInvalidParamsException;
use Yoanm\JsonRpcServerDoc\Domain\Model\ErrorDoc;
use Yoanm\JsonRpcServerDoc\Domain\Model\ServerDoc;
use Yoanm\JsonRpcServerDoc\Domain\Model\Type\ArrayDoc;
use Yoanm\JsonRpcServerDoc\Domain\Model\Type\ObjectDoc;
use Yoanm\JsonRpcServerDoc\Domain\Model\Type\StringDoc;
use Yoanm\SymfonyJsonRpcHttpServerDoc\Event\ServerDocCreatedEvent;
use Yoanm\SymfonyJsonRpcParamsSfConstraintsDoc\Listener\ServerDocCreatedListener;

/**
 * @covers \Yoanm\SymfonyJsonRpcParamsSfConstraintsDoc\Listener\ServerDocCreatedListener
 */
class ServerDocCreatedListenerTest extends TestCase
{
    use ProphecyTrait;

    /** @var ServerDocCreatedListener */
    private $listener;

    protected function setUp(): void
    {
        $this->listener = new ServerDocCreatedListener();
    }

    public function testShouldCreateParamsValidationErrorIfNotExist()
    {
        $serverDoc = new ServerDoc();
        $event = new ServerDocCreatedEvent($serverDoc);

        $this->listener->enhanceParamValidationErrorDoc($event);

        [$paramsValidationError] = $serverDoc->getServerErrorList();

        $this->assertValidParamsValidationErrorDoc($paramsValidationError);
    }

    public function testShouldUseExistingParamsValidationError()
    {
        $serverDoc = new ServerDoc();
        $error = new ErrorDoc('Params validations error', JsonRpcInvalidParamsException::CODE);
        $serverDoc->addServerError($error);
        $event = new ServerDocCreatedEvent($serverDoc);

        $this->listener->enhanceParamValidationErrorDoc($event);

        $this->assertValidParamsValidationErrorDoc($error);
    }

    /**
     * @param $paramsValidationError
     */
    private function assertValidParamsValidationErrorDoc($paramsValidationError): void
    {
        $this->assertInstanceOf(ErrorDoc::class, $paramsValidationError);
        $this->assertSame('Params validations error', $paramsValidationError->getTitle());
        $this->assertSame(JsonRpcInvalidParamsException::CODE, $paramsValidationError->getCode());
        $this->assertInstanceOf(ObjectDoc::class, $paramsValidationError->getDataDoc());
        /** @var ObjectDoc $dataDoc */
        $dataDoc = $paramsValidationError->getDataDoc();
        $this->assertFalse($dataDoc->isAllowExtraSibling());
        $this->assertFalse($dataDoc->isAllowMissingSibling());
        $this->assertCount(1, $dataDoc->getSiblingList());
        $this->assertInstanceOf(ArrayDoc::class, $dataDoc->getSiblingList()[0]);
        /** @var ArrayDoc $sibling */
        [$sibling] = $dataDoc->getSiblingList();
        $this->assertSame(JsonRpcInvalidParamsException::DATA_VIOLATIONS_KEY, $sibling->getName());
        $this->assertInstanceOf(ObjectDoc::class, $sibling->getItemValidation());
        /** @var ObjectDoc $itemValidation */
        $itemValidation = $sibling->getItemValidation();
        $this->assertFalse($itemValidation->isAllowExtraSibling());
        $this->assertTrue($itemValidation->isRequired());
        $this->assertCount(3, $itemValidation->getSiblingList());
        $this->assertContainsOnlyInstancesOf(StringDoc::class, $itemValidation->getSiblingList());
        /** @var StringDoc $pathSibling */
        /** @var StringDoc $messageSibling */
        /** @var StringDoc $codeSibling */
        [$pathSibling, $messageSibling, $codeSibling] = $itemValidation->getSiblingList();
        // path
        $this->assertSame('path', $pathSibling->getName());
        $this->assertSame('[key]', $pathSibling->getExample());
        $this->assertTrue($pathSibling->isRequired());
        // message
        $this->assertSame('message', $messageSibling->getName());
        $this->assertTrue($messageSibling->isRequired());
        // code
        $this->assertSame('code', $codeSibling->getName());
        $this->assertFalse($codeSibling->isRequired());
    }
}
