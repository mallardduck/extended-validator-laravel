<?php

namespace MallardDuck\ExtendedValidator\Rules;

use Illuminate\Support\Str;

abstract class BaseRule
{
    /**
     * @var string
     */
    public $name;

    /**
     * @var callable
     */
    public $callback;

    /**
     * @var string
     */
    public $message;

    /**
     * @var callable
     */
    public $replacer;

    public function __construct(callable $callback, string $message, ?callable $replacer)
    {
        $this->name = $this->getImplicitRuleName();
        $this->callback = $callback;
        $this->message = $message;
        $this->replacer = $replacer;
    }

    protected function getImplicitRuleName(): string
    {
        return Str::of(static::class)->after('Rules\\')->snake();
    }
}
