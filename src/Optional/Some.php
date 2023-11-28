<?php

declare(strict_types=1);

namespace Tactics\Monad\Optional;

use Tactics\Monad\Optional;

final class Some implements Optional
{
    private function __construct(
        protected readonly mixed $value
    ) {
    }

    public static function of($value): Some
    {
        return new self($value);
    }

    public function bind(callable $fn): None
    {
        return $fn($this->value);
    }

    /**
     * @throws \Exception
     */
    public function unwrap(): mixed
    {
        return $this->value;
    }

    public function map(callable $fn): Some
    {
        return self::of($fn($this->value));
    }
}
