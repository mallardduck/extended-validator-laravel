<?php

declare(strict_types=1);

namespace MallardDuck\ExtendedValidator\Rules;

final class HexColor extends BaseRule
{
    public function __construct()
    {
        parent::__construct(
            static function (
                string $attribute,
                $value
            ) {
                return (bool) preg_match(
                    '/^#?(?:[0-9a-fA-F]{3}){1,2}$/',
                    $value,
                ) !== false;
            },
            'The :attribute field must be a valid 3 or 6 character HEX color code.'
        );
    }
}
