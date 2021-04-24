<?php declare(strict_types=1);

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
     * @var callable|null
     */
    protected $replacer = null;

    public function __construct(callable $callback, string $message, ?callable $replacer = null)
    {
        $this->name = $this->getImplicitRuleName();
        $this->callback = $callback;
        $this->message = $message;
        $this->replacer = $replacer;
    }

    protected function getImplicitRuleName(): string
    {
        return (string) Str::of(static::class)
                            ->after('Rules\\')
                            ->snake();
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCallback(): callable
    {
        return $this->callback;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function hasReplacer(): bool
    {
        return is_callable($this->replacer);
    }

    public function getReplacer(): ?callable
    {
        return $this->replacer;
    }
}
