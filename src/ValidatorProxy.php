<?php

namespace MallardDuck\OpinionatedValidator;

use Illuminate\Support\Arr;
use Illuminate\Validation\Validator;

class ValidatorProxy
{

    /**
     * @var Validator
     */
    private $validator;

    private function __construct(Validator $validator)
    {
        $this->validator = $validator;
    }

    public static function setValidator(Validator $validator): self
    {
        return new self($validator);
    }

    // TODO: Consider making a __call() to make this a real proxy class.
    // TODO: Add tests to cover all the duplicated code.

    /**
     * Get the value of a given attribute.
     *
     * @param  string  $attribute
     * @return mixed
     */
    protected function getValue($attribute)
    {
        return Arr::get($this->validator->getData(), $attribute);
    }

    /**
     * Determine if all of the given attributes fail the required test.
     *
     * @param  array  $attributes
     * @return bool
     */
    public function allFailingRequired(array $attributes): bool
    {
        foreach ($attributes as $key) {
            if ($this->validator->validateRequired($key, $this->getValue($key))) {
                return false;
            }
        }

        return true;
    }

    /**
     * Determine if any of the given attributes fail the required test.
     *
     * @param  array  $attributes
     * @return bool
     */
    public function anyFailingRequired(array $attributes)
    {
        foreach ($attributes as $key) {
            if (! $this->validator->validateRequired($key, $this->getValue($key))) {
                return true;
            }
        }

        return false;
    }

}