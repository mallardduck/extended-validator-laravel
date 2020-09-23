<?php

namespace MallardDuck\OpinionatedValidator\Rules;

use Illuminate\Support\Str;
use Illuminate\Validation\Validator;
use MallardDuck\OpinionatedValidator\ValidatorProxy;

final class UnfilledIf extends BaseRule
{
    public function __construct()
    {
        $ruleName = Str::snake(explode('\\', __CLASS__)[3]);
        parent::__construct(
            $ruleName,
            function (
                string $attribute,
                $value,
                $parameters,
                Validator $validator
            ) use ($ruleName) {
                $validator->requireParameterCount(1, $parameters, $ruleName);

                $validatorProxy = ValidatorProxy::setValidator($validator);

                [$values, $other] = $validatorProxy->prepareValuesAndOther($parameters);

                if (in_array($other, $values, true)) {
                    return ! $validator->validateRequired($attribute, $value);
                }

                return true;
            },
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
