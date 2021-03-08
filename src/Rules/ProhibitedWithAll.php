<?php

namespace MallardDuck\ExtendedValidator\Rules;

use Illuminate\Support\Str;
use Illuminate\Validation\Validator;
use MallardDuck\ExtendedValidator\ValidatorProxy;

class ProhibitedWithAll extends BaseRule
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
                // Bail early if value is passed but null.
                if (null === $value) {
                    return true;
                }
                $validator->requireParameterCount(2, $parameters, $ruleName);

                $validatorProxy = ValidatorProxy::fromValidator($validator);
                if ($validatorProxy->allRequired($parameters)) {
                    return false;
                }

                return true;
            },
            'The use of :attribute field is prohibited when :values are present.',
            function (
                $stringTemplate,
                $currentField,
                $rule,
                $ruleArgs,
                $validator
            ) {
                $argCount = count($ruleArgs);
                $values = '';
                foreach ($ruleArgs as $arg) {
                    $values .= $arg;
                    if (2 === $argCount) {
                        $values .= ' and ';
                    } elseif ($argCount >= 3) {
                        $values .= ', ';
                        $argCount--;
                    }
                }

                return Str::replaceFirst(':values', $values, $stringTemplate);
            }
        );
    }
}
