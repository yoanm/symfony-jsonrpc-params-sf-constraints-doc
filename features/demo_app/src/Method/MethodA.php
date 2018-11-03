<?php
namespace DemoApp\Method;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\Type;
use Yoanm\JsonRpcParamsSymfonyValidator\Domain\MethodWithValidatedParamsInterface;
use Yoanm\JsonRpcServer\Domain\JsonRpcMethodInterface;

class MethodA implements JsonRpcMethodInterface, MethodWithValidatedParamsInterface
{
    /**
     * {@inheritdoc}
     */
    public function validateParams(array $paramList) : array
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function apply(array $paramList = null)
    {
        return 'MethodA';
    }

    /**
     * {@inheritdoc}
     */
    public function getParamsConstraint(): Constraint
    {
        return new Collection([
            'a' => new Type('string'),
            'b' => new Type('integer'),
        ]);
    }
}
