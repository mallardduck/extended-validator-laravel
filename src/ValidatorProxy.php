<?php

namespace MallardDuck\OpinionatedValidator;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
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
        // TODO: Add a DATA property and make it a magic accessor for the getData method on the real validator.
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

    /**
     * Prepare the values and the other value for validation.
     *
     * @param  array  $parameters
     * @return array
     */
    public function prepareValuesAndOther($parameters)
    {
        $other = Arr::get($this->validator->getData(), $parameters[0]);

        $values = array_slice($parameters, 1);

        if (is_bool($other)) {
            $values = $this->convertValuesToBoolean($values);
        } elseif (is_null($other)) {
            $values = $this->convertValuesToNull($values);
        }

        return [$values, $other];
    }

    /**
     * Convert the given values to boolean if they are string "true" / "false".
     *
     * @param  array  $values
     * @return array
     */
    public function convertValuesToBoolean($values): array
    {
        return array_map(static function ($value) {
            if ($value === 'true') {
                return true;
            }

            if ($value === 'false') {
                return false;
            }

            return $value;
        }, $values);
    }

    /**
     * Convert the given values to null if they are string "null".
     *
     * @param  array  $values
     * @return array
     */
    public function convertValuesToNull($values): array
    {
        return array_map(static function ($value) {
            return Str::lower($value) === 'null' ? null : $value;
        }, $values);
    }

}