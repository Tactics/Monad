<?php

declare(strict_types=1);

namespace Tactics\Monad\Context;

use Tactics\Monad\Optional;
use Traversable;

interface Contexts extends Traversable
{
    public function get(string $class): Optional;

    public function add(Context $context): Contexts;
}
