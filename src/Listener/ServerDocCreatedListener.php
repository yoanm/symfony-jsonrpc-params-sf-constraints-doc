<?php
namespace Yoanm\SymfonyJsonRpcParamsSfConstraintsDoc\Listener;

use Yoanm\JsonRpcServer\Domain\Exception\JsonRpcInvalidParamsException;
use Yoanm\JsonRpcServerDoc\Domain\Model\ErrorDoc;
use Yoanm\JsonRpcServerDoc\Domain\Model\Type\ArrayDoc;
use Yoanm\JsonRpcServerDoc\Domain\Model\Type\ObjectDoc;
use Yoanm\JsonRpcServerDoc\Domain\Model\Type\StringDoc;
use Yoanm\SymfonyJsonRpcHttpServerDoc\Event\ServerDocCreatedEvent;

/**
 * Class ServerDocCreatedListener
 */
class ServerDocCreatedListener
{
    /**
     * @param ServerDocCreatedEvent $event
     */
    public function enhanceParamValidationErrorDoc(ServerDocCreatedEvent $event) : void
    {
        $paramsValidationError = null;

        // Search for existing error in server errors list
        foreach ($event->getDoc()->getServerErrorList() as $serverError) {
            if (JsonRpcInvalidParamsException::CODE === $serverError->getCode()) {
                $paramsValidationError = $serverError;
                break;
            }
        }

        if (null === $paramsValidationError) {
            // In case not found => Create new one and append it to server error list
            $paramsValidationError = new ErrorDoc('Params validations error', JsonRpcInvalidParamsException::CODE);
            $event->getDoc()->addServerError($paramsValidationError);
        }

        // In case error was already defined, the data doc will be overridden
        $paramsValidationError->setDataDoc(
            (new ObjectDoc())
                ->setAllowMissingSibling(false)
                ->setAllowExtraSibling(false)
                ->setRequired(true)
                ->addSibling(
                    (new ArrayDoc())
                        ->setName(JsonRpcInvalidParamsException::DATA_VIOLATIONS_KEY)
                        ->setItemValidation(
                            (new ObjectDoc())
                                ->setAllowExtraSibling(false)
                                ->setRequired(true)
                                ->addSibling(
                                    (new StringDoc())
                                        ->setName('path')
                                        ->setExample('[key]')
                                        ->setRequired(true)
                                )
                                ->addSibling(
                                    (new StringDoc())
                                        ->setName('message')
                                        ->setRequired(true)
                                )
                                ->addSibling(
                                    (new StringDoc())
                                        ->setName('code')
                                )
                        )
                )
        );
    }
}
