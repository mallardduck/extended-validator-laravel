<?php

namespace MallardDuck\ExtendedValidator\Rules;

use Illuminate\Validation\Validator;

class HexColor extends BaseRule
{
    public function __construct()
    {
        $ruleName = $this->getRuleName(__CLASS__);
        parent::__construct(
            $ruleName,
            static function (
                string $attribute,
                $value
            ) {
                return (bool) preg_match('/^#?(?:[0-9a-fA-F]{3}){1,2}$/', $value, $results) !== false;
            },
            'The :attribute field must be a valid 3 or 6 character HEX color code.',
            null
        );
    }
}