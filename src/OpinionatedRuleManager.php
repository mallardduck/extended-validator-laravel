<?php

namespace MallardDuck\OpinionatedValidator;

use MallardDuck\OpinionatedValidator\Rules\UnfilledIf;
use MallardDuck\OpinionatedValidator\Rules\UnfilledWith;

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
    ];

    public static function allRules(): array
    {
        return [
            'rules' => self::$rules,
            'implicit' => self::$implicitRules,
            'dependent' => self::$dependentRules,
        ];
    }
}