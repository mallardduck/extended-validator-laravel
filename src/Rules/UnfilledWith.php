<?php

namespace MallardDuck\OpinionatedValidator\Rules;

use Illuminate\Support\Str;
use Illuminate\Validation\Validator;
use MallardDuck\OpinionatedValidator\ValidatorProxy;

final class UnfilledWith extends BaseRule
{
    public function __construct()
    {
        $ruleName = Str::snake(explode('\\', __CLASS__)[3]);
        parent::__construct(
            $ruleName,
            static function (
                string $attribute,
                $value,
                $parameters,
                Validator $validator
            ) use ($ruleName) {
                $validator->requireParameterCount(1, $parameters, $ruleName);

                $validatorProxy = ValidatorProxy::setValidator($validator);

                if (! $validatorProxy->allFailingRequired($parameters)) {
                    return false;
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
                $values = implode('/', $ruleArgs);
                return Str::replaceFirst(':values', $values, $stringTemplate);
            }
        );
    }
}