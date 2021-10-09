<?php

declare(strict_types=1);

namespace MallardDuck\ExtendedValidator\Rules;

use Illuminate\Validation\Validator;

final class NotInIf extends BaseRule
{
    public function __construct()
    {
        parent::__construct(
            $this->getRuleClosure(),
            __('validation.not_in')
        );
    }

    public function getRuleClosure(): \Closure
    {
        $ruleName = $this->getImplicitRuleName();
        return static function (string $attribute, $value, $parameters, Validator $validator) use ($ruleName) {
            $validator->requireParameterCount(2, $parameters, $ruleName);

            [$values, $other] = $validator->parseDependentRuleParameters($parameters);
            if ($other) {
                return ! in_array($value, $values);
            }

            return true;
        };
    }
}
