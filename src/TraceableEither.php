<?php

declare(strict_types=1);

namespace Tactics\Monad;

use Tactics\Monad\Either\Success;
use Tactics\Monad\Either\Failure;

/**
 * Either Monad (Result)
 *
 * Either monad represents either a Success or a Failure.
 * In this interface, we restrict the common monad to these
 * two types.
 */
interface TraceableEither extends Either, Writer, Reader
{
    public function bind(callable $fn): Success|Failure;

    public function unwrap(): mixed;

    public function map(callable $fn): Success|Failure;

    public function lift(mixed $value): Success;

}
