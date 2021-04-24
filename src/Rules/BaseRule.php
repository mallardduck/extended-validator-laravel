<?php

namespace MallardDuck\ExtendedValidator\Rules;

use Illuminate\Support\Str;

abstract class BaseRule
{
    /**
     * @var string
     */
    protected string $name;

    /**
     * @var callable
     */
    protected $callback;

    /**
     * @var string
     */
    protected string $message;

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

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return callable
     */
    public function getCallback(): callable
    {
        return $this->callback;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }
}
