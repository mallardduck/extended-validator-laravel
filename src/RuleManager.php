<?php

namespace MallardDuck\ExtendedValidator;

use Illuminate\Support\Str;
use MallardDuck\ExtendedValidator\Rules\HexColor;
use MallardDuck\ExtendedValidator\Rules\HexColorWithAlpha;
use MallardDuck\ExtendedValidator\Rules\MacAddress;
use MallardDuck\ExtendedValidator\Rules\PublicIp;
use MallardDuck\ExtendedValidator\Rules\PublicIpv4;
use MallardDuck\ExtendedValidator\Rules\PublicIpv6;
use MallardDuck\ExtendedValidator\Rules\ProhibitedIf;
use MallardDuck\ExtendedValidator\Rules\ProhibitedWith;
use MallardDuck\ExtendedValidator\Rules\ProhibitedWithAll;

class RuleManager
{
    protected static $rules = [
        HexColor::class,
        HexColorWithAlpha::class,
        PublicIp::class,
        PublicIpv4::class,
        PublicIpv6::class,
        MacAddress::class,
    ];

    protected static $implicitRules = [];

    protected static $dependentRules = [
        ProhibitedWith::class,
        ProhibitedWithAll::class,
    ];

    public static function allRuleNames(): array
    {
        static $allRuleNames = null;
        if (is_null($allRuleNames)) {
            $allRuleNames = collect(array_merge(
                self::$rules,
                self::$implicitRules,
                self::$dependentRules,
            ))->map(static function ($value) {
                return Str::snake(explode('\\', $value)[3]);
            })->unique()->toArray();
        }

        return $allRuleNames;
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
