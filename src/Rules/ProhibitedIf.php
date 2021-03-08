<?php

namespace MallardDuck\ExtendedValidator\Rules;

use Illuminate\Support\Str;
use Illuminate\Validation\Validator;
use MallardDuck\ExtendedValidator\ValidatorProxy;

final class ProhibitedIf extends BaseRule
{
    public function __construct()
    {
        $ruleName = $this->getRuleName(__CLASS__);
        parent::__construct(
            $ruleName,
            function (
                string $attribute,
                $value,
                $parameters,
                Validator $validator
            ) use ($ruleName) {
                $validator->requireParameterCount(1, $parameters, $ruleName);

                $validatorProxy = ValidatorProxy::fromValidator($validator);

                [$values, $other] = $validatorProxy->prepareValuesAndOther($parameters);

                if (in_array($other, $values, true)) {
                    return ! $validator->validateRequired($attribute, $value);
                }

                return true;
            },
            'The use of :attribute field is prohibited when :other field is :value.',
            function (
                $stringTemplate,
                $currentField,
                $rule,
                $ruleArgs,
                $validator
            ) {
                [$other, $value] = $ruleArgs;
                $results = Str::replaceFirst(':other', $other, $stringTemplate);
                $results = Str::replaceFirst(':value', $value, $results);

                return $results;
            }
        );
    }
}