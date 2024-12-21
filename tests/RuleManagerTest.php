<?php

namespace MallardDuck\ExtendedValidator\Tests;

use Illuminate\Support\Str;
use MallardDuck\ExtendedValidator\RuleManager;

class RuleManagerTest extends BaseTestCase
{
    public function testBasicRuleCheck()
    {
        $count = RuleManager::shouldIncludeHexColor() ? 10 : 9;
        $allRuleNames = RuleManager::allRuleNames();
        self::assertCount($count, $allRuleNames);
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
