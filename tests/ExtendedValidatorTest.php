<?php

namespace MallardDuck\ExtendedValidator\Tests;

use MallardDuck\ExtendedValidator\RuleManager;
use MallardDuck\ExtendedValidator\Rules\BaseRule;

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

                if (! array_key_exists($ruleInstance->getName(), $tracedRules) && ! is_null($ruleInstance->replacer)) {
                    $replacerCount++;
                    $tracedRules[$ruleInstance->getName()] = $ruleInstance->getName();
                }
            }
        }

        $registeredReplacers = $this->getPrivatePropertyValueFromObject($validatorFactory, 'replacers');

        self::assertCount($replacerCount, $registeredReplacers);
    }
}
