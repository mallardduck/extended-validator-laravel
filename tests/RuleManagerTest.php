<?php

namespace MallardDuck\ExtendedValidator\Tests;

use Illuminate\Support\Str;
use MallardDuck\ExtendedValidator\RuleManager;

class RuleManagerTest extends \MallardDuck\ExtendedValidator\Tests\BaseTest
{
    public function testBasicRuleCheck()
    {
        $allRuleNames = RuleManager::allRuleNames();
        self::assertCount(9, $allRuleNames);
    }

    public function testRuleNamesOutputMatchesAllRules()
    {
        $allRuleNames = RuleManager::allRuleNames();

        $allRules = RuleManager::allRules();
        $namesFromRules = collect($allRules)
                            ->flatten()
                            ->map(static function ($value) {
                                return Str::snake(explode('\\', $value)[3]);
                            })->unique()->toArray();


        self::assertCount(count($namesFromRules), $allRuleNames);
    }
}
