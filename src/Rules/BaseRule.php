<?php

namespace MallardDuck\UnfilledValidator\Rules;

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
     * @var callable
     */
    public $resolver;

    public function __construct(string $name, callable $callback, callable $resolver)
    {
        $this->name = $name;
        $this->callback = $callback;
        $this->resolver = $resolver;
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