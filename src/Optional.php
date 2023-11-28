<?php

declare(strict_types=1);

namespace Tactics\Monad;

use Tactics\Monad\Optional\None;
use Tactics\Monad\Optional\Some;

/**
 * Maybe Monad (Optional)
 *
 * Either monad represents either a Some or a None.
 * In this interface, we restrict the common monad to these
 * two types.
 */
interface Optional extends MonadCommon
{
    public function bind(callable $fn): Some|None;

    public function unwrap(): mixed;

    public function map(callable $fn): Some|None;
}
