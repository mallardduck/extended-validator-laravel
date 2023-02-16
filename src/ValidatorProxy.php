<?php

declare(strict_types=1);

namespace MallardDuck\ExtendedValidator;

use Illuminate\Support\Arr;
use Illuminate\Validation\Validator;

final class ValidatorProxy
{
    private Validator $validator;

    private function __construct(Validator $validator)
    {
        $this->validator = $validator;
    }

    /**
     * @return static
     */
    public static function fromValidator(Validator $validator): self
    {
        return new self($validator);
    }

    /**
     * Determine if all the given attributes pass the required test.
     *
     * @param array<string> $attributes
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
     * Get the value of a given attribute.
     */
    protected function getValue(string $attribute)
    {
        return Arr::get($this->getData(), $attribute);
    }

    /**
     * @return array<string, string|int|float|null>
     */
    private function getData(): array
    {
        return $this->validator->getData();
    }
}
