<?php

declare(strict_types=1);

namespace Tactics\Monad;

use Tactics\Monad\Context\Context;

/**
 * Monad including reader functionality.
 */
interface Reader extends Carrier
{
    public function withContext(Context $context): Reader;

    public function context(string $class): ?Context;
}
