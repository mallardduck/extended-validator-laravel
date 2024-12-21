<?php

declare(strict_types=1);

namespace MallardDuck\ExtendedValidator;

use Composer\Semver\Comparator;
use Illuminate\Foundation\Application;
use Illuminate\Support\Str;
use MallardDuck\ExtendedValidator\Rules\HexColor;
use MallardDuck\ExtendedValidator\Rules\HexColorWithAlpha;
use MallardDuck\ExtendedValidator\Rules\MacAddress;
use MallardDuck\ExtendedValidator\Rules\NonPublicIpv4;
use MallardDuck\ExtendedValidator\Rules\NotInIf;
use MallardDuck\ExtendedValidator\Rules\NotInIfValue;
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
        NotInIf::class,
        NotInIfValue::class,
        ProhibitedWithAll::class,
    ];

    public static function shouldIncludeHexColor(): bool
    {
        $laravelVersion = Application::VERSION;
        return Comparator::lessThan($laravelVersion, "10.33.0");
    }

    /**
     * @return array<string>
     */
    public static function allRuleNames(): array
    {
        $rules = self::$rules;
        if (self::shouldIncludeHexColor()) {
            $rules[] = HexColor::class;
        }

        static $allRuleNames = null;
        if (is_null($allRuleNames)) {
            $allRuleNames = collect($rules)->merge(self::$dependentRules)
                ->map(
                    static function ($value) {
                        return Str::snake(explode('\\', $value)[3]);
                    }
                )->unique()->toArray();
        }

        return $allRuleNames;
    }

    /**
     * @return array<string, array<string>>
     */
    public static function allRules(): array
    {
        $rules = self::$rules;
        if (self::shouldIncludeHexColor()) {
            $rules[] = HexColor::class;
        }
        return [
            'rules' => $rules,
            'dependent' => self::$dependentRules,
        ];
    }
}
