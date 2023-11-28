<?php

declare(strict_types=1);

namespace Tactics\Monad;

/**
 * An interface for common monad functionalities.
 */
interface MonadCommon
{
    public function bind(callable $fn): MonadCommon;

    public function unwrap(): mixed;

    public function map(callable $fn): MonadCommon;

}
