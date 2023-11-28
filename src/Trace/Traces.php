<?php

declare(strict_types=1);

namespace Tactics\Monad\Trace;

use Traversable;

interface Traces extends Traversable
{
    public function add(Trace $trace): Traces;
}
