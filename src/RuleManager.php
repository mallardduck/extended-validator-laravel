<?php

declare(strict_types=1);

namespace MallardDuck\ExtendedValidator;

use Illuminate\Support\Str;
use MallardDuck\ExtendedValidator\Rules\HexColor;
use MallardDuck\ExtendedValidator\Rules\HexColorWithAlpha;
use MallardDuck\ExtendedValidator\Rules\MacAddress;
use MallardDuck\ExtendedValidator\Rules\NonPublicIpv4;
use MallardDuck\ExtendedValidator\Rules\ProhibitedWith;
use MallardDuck\ExtendedValidator\Rules\ProhibitedWithAll;
use MallardDuck\ExtendedValidator\Rules\PublicIp;
use MallardDuck\ExtendedValidator\Rules\PublicIpv4;
use MallardDuck\ExtendedValidator\Rules\PublicIpv6;

final class RuleManager
{
    /**
     * @var array<string>
     */
    protected static array $rules = [
        HexColor::class,
        HexColorWithAlpha::class,
        PublicIp::class,
        PublicIpv4::class,
        PublicIpv6::class,
        NonPublicIpv4::class,
        MacAddress::class,
    ];

    /**
     * @var array<string>
     */
    protected static array $dependentRules = [
        ProhibitedWith::class,
        ProhibitedWithAll::class,
    ];

    /**
     * @return array<string>|null
     */
    public static function allRuleNames(): array
    {
        static $allRuleNames = null;
        if (is_null($allRuleNames)) {
            $allRuleNames = collect(self::$rules)->merge(self::$dependentRules)
                ->map(static function ($value) {
                    return Str::snake(explode('\\', $value)[3]);
                })->unique()->toArray();
        }

        return $allRuleNames;
    }

    /**
     * @return array<string, array<string>>
     */
    public static function allRules(): array
    {
        return [
            'rules' => self::$rules,
            'dependent' => self::$dependentRules,
        ];
    }
}
