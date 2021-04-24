<?php

declare(strict_types=1);

namespace MallardDuck\ExtendedValidator\Rules;

use Illuminate\Support\Str;
use Illuminate\Validation\Validator;
use MallardDuck\ExtendedValidator\ValidatorProxy;

final class ProhibitedWith extends BaseRule
{
    public function __construct()
    {
        parent::__construct(
            $this->baseRule(),
            'The use of :attribute field is prohibited when :values is present.',
            function (
                $stringTemplate,
                $currentField,
                $rule,
                $ruleArgs,
                $validator
            ) {
                $values = implode('/', $ruleArgs);
                return Str::replaceFirst(':values', $values, $stringTemplate);
            }
        );
    }

    public function baseRule(): \Closure
    {
        $ruleName = $this->getImplicitRuleName();
        return static function (string $attribute, $value, $parameters, Validator $validator) use ($ruleName) {
            // Bail early if value is passed but null.
            if ($value === null) {
                return true;
            }
            $validator->requireParameterCount(1, $parameters, $ruleName);

            $validatorProxy = ValidatorProxy::fromValidator($validator);

            if (!$validatorProxy->allFailingRequired($parameters)) {
                return false;
            }

            return true;
        };
    }
}
