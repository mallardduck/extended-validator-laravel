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
                $argCount = count($ruleArgs);
                $values = '';
                for ($i = 1; $i <= ($argCount); $i++) {
                    $values .= $ruleArgs[$i-1];
                    if (1 === ($argCount - $i)) {
                        $values .= ' and ';
                    } elseif (0 !== ($argCount - $i)) {
                        $values .= ', ';
                    }
                }

                return Str::replaceFirst(':values', $values, $stringTemplate);
            }
        );
    }
}