<?php

namespace MallardDuck\UnfilledValidator\Tests;

use MallardDuck\UnfilledValidator\RuleManager;

class ExtendedValidatorTest extends BaseTest
{
    public function testValidatorHasBeenExtended()
    {
        $validatorExtensions = $this->getValidator()->make([], [])->extensions;
        $ourRules = RuleManager::allRuleNames();
        foreach ($ourRules as $key => $ruleName) {
            $this->assertArrayHasKey($ruleName, $validatorExtensions);
        }
    }
}
