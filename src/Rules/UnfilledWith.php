<?php

namespace MallardDuck\ExtendedValidator\Rules;

use Illuminate\Support\Str;
use Illuminate\Validation\Validator;
use MallardDuck\ExtendedValidator\ValidatorProxy;

final class UnfilledWith extends BaseRule
{
    public function __construct()
    {
        $ruleName = $this->getRuleName(__CLASS__);
        parent::__construct(
            $ruleName,
            static function (
                string $attribute,
                $value,
                $parameters,
                Validator $validator
            ) use ($ruleName) {
                $validator->requireParameterCount(1, $parameters, $ruleName);

                $validatorProxy = ValidatorProxy::fromValidator($validator);

                if (! $validatorProxy->allFailingRequired($parameters)) {
                    return false;
                }

                return true;
            },
            'The :attribute field must not be used when :values is present.',
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
