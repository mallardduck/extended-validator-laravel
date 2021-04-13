<?php

namespace MallardDuck\ExtendedValidator;

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

    /**
     * @param Validator $validator
     *
     * @return static
     */
    public static function fromValidator(Validator $validator): self
    {
        return new self($validator);
    }

    /**
     * @return array
     */
    private function getData(): array
    {
        return $this->validator->getData();
    }

    /**
     * Get the value of a given attribute.
     *
     * @param  string  $attribute
     *
     * @return mixed
     */
    protected function getValue(string $attribute)
    {
        return Arr::get($this->getData(), $attribute);
    }

    /**
     * Determine if all of the given attributes pass the required test.
     *
     * @param  array  $attributes
     *
     * @return bool
     */
    public function allRequired(array $attributes): bool
    {
        foreach ($attributes as $key) {
            if (! $this->validator->validateRequired($key, $this->getValue($key))) {
                return false;
            }
        }

        return true;
    }

    /**
     * Determine if all of the given attributes fail the required test.
     *
     * @param  array  $attributes
     *
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
}
