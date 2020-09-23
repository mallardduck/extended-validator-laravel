<?php

namespace MallardDuck\OpinionatedValidator\Rules;

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
}