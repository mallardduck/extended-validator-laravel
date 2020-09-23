<?php

namespace MallardDuck\UnfilledValidator;

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
    }

    /**
     * @param Validator $validator
     *
     * @return static
     */
    public static function setValidator(Validator $validator): self
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

    /**
     * Determine if any of the given attributes fail the required test.
     *
     * @param  array  $attributes
     *
     * @return bool
     */
    public function anyFailingRequired(array $attributes): bool
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
     *
     * @return array
     */
    public function prepareValuesAndOther(array $parameters): array
    {
        $other = Arr::get($this->getData(), $parameters[0]);

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
     * @param array $values
     *
     * @return array
     */
    public function convertValuesToBoolean(array $values): array
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
     * @param array $values
     *
     * @return array
     */
    public function convertValuesToNull(array $values): array
    {
        return array_map(static function ($value) {
            return Str::lower($value) === 'null' ? null : $value;
        }, $values);
    }
}
