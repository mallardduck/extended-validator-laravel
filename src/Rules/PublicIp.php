<?php

namespace MallardDuck\UnfilledValidator\Rules;

use Illuminate\Validation\Validator;

class PublicIp extends BaseRule
{
    public function __construct()
    {
        $ruleName = $this->getRuleName(__CLASS__);
        parent::__construct(
            $ruleName,
            function (
                string $attribute,
                $value,
                $parameters,
                Validator $validator
            ) use ($ruleName) {
                return filter_var(
                    $value,
                    FILTER_VALIDATE_IP,
                    FILTER_FLAG_NO_RES_RANGE|FILTER_FLAG_NO_PRIV_RANGE
                ) !== false;
            },
            'The :attribute field must be a valid public IP address.',
            null
        );
    }
}
