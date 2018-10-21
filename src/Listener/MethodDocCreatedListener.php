<?php
namespace Yoanm\SymfonyJsonRpcParamsSfConstraintsDoc\Listener;

use Yoanm\JsonRpcParamsSymfonyConstraintDoc\Infra\Transformer\ConstraintToParamsDocTransformer;
use Yoanm\JsonRpcParamsSymfonyValidator\Domain\MethodWithValidatedParamsInterface;
use Yoanm\SymfonyJsonRpcHttpServerDoc\Event\MethodDocCreatedEvent;

/**
 * Class MethodDocCreatedListener
 */
class MethodDocCreatedListener
{
    /** ConstraintToParamsDocTransformer */
    private $paramDocConverter;

    /**
     * @param ConstraintToParamsDocTransformer $paramDocConverter
     */
    public function __construct(ConstraintToParamsDocTransformer $paramDocConverter)
    {
        $this->paramDocConverter = $paramDocConverter;
    }

    /**
     * @param MethodDocCreatedEvent $event
     */
    public function enhanceMethodDoc(MethodDocCreatedEvent $event)
    {
        $jsonRpcMethod = $event->getMethod();
        if ($jsonRpcMethod instanceof MethodWithValidatedParamsInterface) {
            $paramsDoc = $this->paramDocConverter->transform($jsonRpcMethod->getParamsConstraint());

            // If method have arguments, they are required and not nullable
            $paramsDoc->setNullable(false)
                ->setRequired(true);

            $event->getDoc()->setParamsDoc($paramsDoc);
        }
    }
}
