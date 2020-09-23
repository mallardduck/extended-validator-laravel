<?php

namespace MallardDuck\OpinionatedValidator;

use Illuminate\Support\Str;
use MallardDuck\OpinionatedValidator\Rules\{
    UnfilledIf,
    UnfilledWith,
    UnfilledWithAll,
};

class OpinionatedRuleManager
{
    protected static $rules = [
        // Add regular rules...
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
            ))->map(function ($value) {
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
