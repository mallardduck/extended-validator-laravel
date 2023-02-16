<?php

declare(strict_types=1);

namespace MallardDuck\ExtendedValidator\Rules;

use Closure;

final class NonPublicIpv4 extends BaseRule
{
    public function __construct()
    {
        parent::__construct(
            $this->getRuleClosure(),
            'The :attribute field must be a valid non-public IPv4 address.'
        );
    }

    public function getRuleClosure(): Closure
    {
        return static function (string $attribute, $value) {
            // Eager return as false for anything that's just flat out not an IP.
            if (filter_var($value, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) === false) {
                return false;
            }

            if (
                filter_var(
                    $value,
                    FILTER_VALIDATE_IP,
                    FILTER_FLAG_NO_RES_RANGE | FILTER_FLAG_NO_PRIV_RANGE
                ) === false
            ) {
                return true;
            }

            return false;
        };
    }
}
