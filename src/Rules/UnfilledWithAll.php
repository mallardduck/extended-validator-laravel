<?php

namespace MallardDuck\OpinionatedValidator\Rules;

use Illuminate\Support\Str;
use Illuminate\Validation\Validator;
use MallardDuck\OpinionatedValidator\ValidatorProxy;

class UnfilledWithAll extends BaseRule
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
                $validator->requireParameterCount(2, $parameters, $ruleName);

                $validatorProxy = ValidatorProxy::setValidator($validator);
                if ($validatorProxy->allRequired($parameters)) {
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