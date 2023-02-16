<?php

declare(strict_types=1);

namespace MallardDuck\ExtendedValidator\Rules;

use Closure;
use Illuminate\Validation\Validator;

final class NotInIfValue extends BaseRule
{
    public function __construct()
    {
        parent::__construct(
            $this->getRuleClosure(),
            __('validation.not_in')
        );
    }

    public function getRuleClosure(): Closure
    {
        $ruleName = $this->getImplicitRuleName();
        return static function (
            string $attribute,
            $value,
            $parameters,
            Validator $validator
        ) use ($ruleName) {
            $validator->requireParameterCount(3, $parameters, $ruleName);

            // First prepare the value of $other, then shift the array to get the check value.
            [$values, $other] = $validator->parseDependentRuleParameters($parameters);
            $otherCheck = array_shift($values);
            if ($other === $otherCheck) {
                return ! in_array($value, $values);
            }

            return true;
        };
    }
}
