<?php

declare(strict_types=1);

namespace Tactics\Monad;

use Tactics\Monad\Monads\Either\Failure;
use Tactics\Monad\Monads\Either\Success;
use Tactics\Monad\Trace\Trace;
use Throwable;

/**
 * Either Monad (Result)
 *
 * Either monad represents either a Success or a Failure.
 * In this interface, we restrict the common monad to these
 * two types.
 */
interface Either extends Writer, Reader, Carrier
{
    public function bind(callable $fn): Success|Failure;

    public function unwrap(): mixed;

    public function map(callable $fn): Success|Failure;

    public function lift(mixed $value): Success|Failure;

    public function fail(Fault $fault, Trace|null $trace = null): Failure;
}
