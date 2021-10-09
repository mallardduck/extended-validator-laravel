<?php

declare(strict_types=1);

namespace MallardDuck\ExtendedValidator\Rules;

use Illuminate\Support\Str;
use Illuminate\Validation\Validator;
use InvalidArgumentException;
use MallardDuck\ExtendedValidator\ValidatorProxy;

final class NotInIf extends BaseRule
{
    /**
     * The condition that validates the attribute.
     *
     * @var callable|bool
     */
    public $condition;

    /**
     * @param  callable|bool  $condition
     * @return void
     */
    public function __construct($condition)
    {
        if (! is_string($condition)) {
            $this->condition = $condition;
        } else {
            throw new InvalidArgumentException('The provided condition must be a callable or boolean.');
        }

        parent::__construct(
            $this->baseRule(),
            'TODO',
            function (
                $message,
                $attribute,
                $rule,
                $parameters,
                $validator
            ) {
                dd(
                    $message,
                    $attribute,
                    $rule,
                    $parameters,
                    $validator
                );
            }
        );
    }

    public function baseRule(): \Closure
    {
        // TODO
        return [$this, __METHOD__];
    }
}
