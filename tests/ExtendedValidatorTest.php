<?php

namespace MallardDuck\ExtendedValidator\Tests;

use MallardDuck\ExtendedValidator\RuleManager;
use MallardDuck\ExtendedValidator\Rules\BaseRule;
use Roave\BetterReflection\Reflection\ReflectionClass;
use Roave\BetterReflection\Reflection\ReflectionFunction;
use Roave\BetterReflection\Reflection\ReflectionObject;

class ExtendedValidatorTest extends BaseTest
{
    public function testValidatorHasBeenExtended()
    {
        $validatorExtensions = $this->getValidator()->make([], [])->extensions;
        $ourRules = RuleManager::allRuleNames();
        foreach ($ourRules as $key => $ruleName) {
            self::assertArrayHasKey($ruleName, $validatorExtensions);
        }
    }

    public function testValidatorHasAllReplacersExtended()
    {
        $validatorFactory = $this->getValidator();
        $replacerCount = 0;

        $tracedRules = [];
        foreach (RuleManager::allRules() as $ruleType => $rules) {
            foreach ($rules as $key => $rule) {
                /** @var BaseRule $ruleInstance */
                $ruleInstance = new $rule();

                if (! array_key_exists($ruleInstance->name, $tracedRules) && ! is_null($ruleInstance->replacer)) {
                    $replacerCount++;
                    $tracedRules[$ruleInstance->name] = $ruleInstance->name;
                }
            }
        }

        $validatorReflection = ReflectionObject::createFromInstance($validatorFactory);
        $registeredReplacers = $validatorReflection->getProperty('replacers')->getValue($validatorFactory);

        self::assertCount($replacerCount, $registeredReplacers);
    }

    public function testValidatorHasAllImplicitRulesExtended()
    {
        $validatorFactory = $this->getValidator();
        $implicitCount = 0;

        $tracedRules = [];
        foreach (RuleManager::allRules()['implicit'] as $key => $rule) {
            /** @var BaseRule $ruleInstance */
            $ruleInstance = new $rule();

            if (! array_key_exists($ruleInstance->name, $tracedRules) && ! is_null($ruleInstance->replacer)) {
                $implicitCount++;
                $tracedRules[$ruleInstance->name] = new $rule();
            }
        }

        $validatorReflection = ReflectionObject::createFromInstance($validatorFactory);
        $registeredImplicitRules = $validatorReflection->getProperty('implicitExtensions')->getValue($validatorFactory);

        self::assertCount($implicitCount, $registeredImplicitRules);

        foreach ($tracedRules as $ourRule) {
            self::assertArrayHasKey($ourRule->name, $registeredImplicitRules);
        }
    }
}
