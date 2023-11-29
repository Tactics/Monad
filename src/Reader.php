<?php

declare(strict_types=1);

namespace Tactics\Monad;

use Tactics\Monad\Context\Context;

/**
 * Monad including reader functionality.
 */
interface Reader
{
    public function withContext(Context $context): Reader;

    public function context(string $class): Optional;

    public function clearContext(string $class): Reader;

}
