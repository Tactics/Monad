<?php

declare(strict_types=1);

namespace Tactics\Monad\Monads\Optional;

use Tactics\Monad\Optional;
use ValueError;

final class None implements Optional
{
    public static function of(): self
    {
        return new self();
    }

    public function bind(callable $fn): None
    {
        return $this;
    }

    public function unwrap(): mixed
    {
        throw new ValueError('Value of None can not be unwrapped');
    }

    public function map(callable $fn): None
    {
        return $this;
    }
}
