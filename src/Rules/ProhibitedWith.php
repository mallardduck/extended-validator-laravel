<?php

namespace MallardDuck\ExtendedValidator\Rules;

use Illuminate\Support\Str;
use Illuminate\Validation\Validator;
use MallardDuck\ExtendedValidator\ValidatorProxy;

final class ProhibitedWith extends BaseRule
{
    public function __construct()
    {
        $ruleName = $this->getImplicitRuleName();
        parent::__construct(
            static function (
                string $attribute,
                $value,
                $parameters,
                Validator $validator
            ) use ($ruleName) {
                // Bail early if value is passed but null.
                if (null === $value) {
                    return true;
                }
                $validator->requireParameterCount(1, $parameters, $ruleName);

                $validatorProxy = ValidatorProxy::fromValidator($validator);

                if (!$validatorProxy->allFailingRequired($parameters)) {
                    return false;
                }

                return true;
            },
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
}
