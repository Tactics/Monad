<?php

declare(strict_types=1);

namespace Tactics\Monad\Context;

interface Context
{
    public function type() : ContextType;
}
