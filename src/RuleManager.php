<?php

namespace MallardDuck\UnfilledValidator;

use Illuminate\Support\Str;
use MallardDuck\UnfilledValidator\Rules\MacAddress;
use MallardDuck\UnfilledValidator\Rules\PublicIp;
use MallardDuck\UnfilledValidator\Rules\PublicIpv4;
use MallardDuck\UnfilledValidator\Rules\PublicIpv6;
use MallardDuck\UnfilledValidator\Rules\UnfilledIf;
use MallardDuck\UnfilledValidator\Rules\UnfilledWith;
use MallardDuck\UnfilledValidator\Rules\UnfilledWithAll;

class RuleManager
{
    protected static $rules = [
        PublicIp::class,
        PublicIpv4::class,
        PublicIpv6::class,
        MacAddress::class,
    ];

    protected static $implicitRules = [
        // Add implicit rules...
    ];

    protected static $dependentRules = [
        UnfilledIf::class,
        UnfilledWith::class,
        UnfilledWithAll::class,
    ];

    public static function allRuleNames(): array
    {
        static $allRules = null;
        if (is_null($allRules)) {
            $allRules = collect(array_merge(
                self::$rules,
                self::$implicitRules,
                self::$dependentRules,
            ))->map(static function ($value) {
                return Str::snake(explode('\\', $value)[3]);
            })->toArray();
        }

        return $allRules;
    }

    public static function allRules(): array
    {
        return [
            'rules' => self::$rules,
            'implicit' => self::$implicitRules,
            'dependent' => self::$dependentRules,
        ];
    }
}
