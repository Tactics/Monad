<?php

declare(strict_types=1);

namespace Tactics\Monad;

use Tactics\Monad\Trace\Trace;
use Tactics\Monad\Trace\Traces;

/**
 * All-in Either for the most common cases.
 */
interface Writer extends Carrier
{
    public function withTrace(Trace $trace): Writer;

    public function traces(): Traces;
}
