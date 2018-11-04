<?php
namespace DemoApp\Method;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints\All;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\Type;
use Yoanm\JsonRpcParamsSymfonyValidator\Domain\MethodWithValidatedParamsInterface;
use Yoanm\JsonRpcServer\Domain\JsonRpcMethodInterface;

class MethodC implements JsonRpcMethodInterface, MethodWithValidatedParamsInterface
{
    /**
     * {@inheritdoc}
     */
    public function apply(array $paramList = null)
    {
        return 'MethodC';
    }

    /**
     * {@inheritdoc}
     */
    public function getParamsConstraint(): Constraint
    {
        return new Collection([
            'a' => new All([
                new Type('integer')
            ]),
        ]);
    }
}
