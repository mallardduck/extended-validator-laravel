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

    public function __construct(string $name, callable $callback, string $message, ?callable $replacer)
    {
        $this->name = $name;
        $this->callback = $callback;
        $this->message = $message;
        $this->replacer = $replacer;
    }

    /**
     * @param string $className
     *
     * @return string
     */
    protected function getRuleName(string $className): string
    {
        return Str::snake(explode('\\', $className)[3]);
    }
}
