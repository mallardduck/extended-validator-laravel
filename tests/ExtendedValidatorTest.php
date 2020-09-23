<?php

namespace MallardDuck\OpinionatedValidator\Tests;

use Illuminate\Validation\Factory;
use MallardDuck\OpinionatedValidator\OpinionatedRuleManager;

class ExtendedValidatorTest extends BaseTest
{
    public function testValidatorHasBeenExtended()
    {
        $validatorExtensions = $this->getValidator()->make([],[])->extensions;
        $ourRules = OpinionatedRuleManager::allRuleNames();
        foreach ($ourRules as $key => $ruleName) {
            $this->assertArrayHasKey($ruleName, $validatorExtensions);
        }
    }
}