<?php

declare(strict_types=1);

namespace Tactics\Monad;

/**
 * Carrier monad, an interface for a monad that will replicate
 * itself with only a value change. This is used to keep context
 * traces over transformations.
 */
interface Carrier extends MonadCommon
{
    public function lift(mixed $value): Carrier;
}
