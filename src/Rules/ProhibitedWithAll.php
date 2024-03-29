<?php

declare(strict_types=1);

namespace MallardDuck\ExtendedValidator\Rules;

use Closure;
use Illuminate\Support\Str;
use Illuminate\Validation\Validator;
use MallardDuck\ExtendedValidator\ValidatorProxy;

final class ProhibitedWithAll extends BaseRule
{
    public function __construct()
    {
        parent::__construct(
            $this->getRuleClosure(),
            'The use of :attribute field is prohibited when :values are present.',
            $this->getReplacerClosure()
        );
    }

    public function getRuleClosure(): Closure
    {
        $ruleName = $this->getImplicitRuleName();
        return static function (
            string $attribute,
            $value,
            $parameters,
            Validator $validator
        ) use ($ruleName) {
            // Bail early if value is passed but null.
            if ($value === null) {
                return true;
            }
            $validator->requireParameterCount(2, $parameters, $ruleName);

            $validatorProxy = ValidatorProxy::fromValidator($validator);
            if ($validatorProxy->allRequired($parameters)) {
                return false;
            }

            return true;
        };
    }

    public function getReplacerClosure(): Closure
    {
        return static function (
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
                if ($argCount === 2) {
                    $values .= ' and ';
                } elseif ($argCount >= 3) {
                    $values .= ', ';
                    $argCount--;
                }
            }

            return Str::replaceFirst(':values', $values, $stringTemplate);
        };
    }
}
