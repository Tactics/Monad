<?php

declare(strict_types=1);

namespace Tactics\Monad\Context;

enum ContextType: string
{
    case Persistent = 'persistent';
    case Transient = 'transient';

    /**
     * Utility method to check if a context is persistent
     */
    public function isPersistent(): bool
    {
        return $this === self::Persistent;
    }

    /**
     * Utility method to check if a context is transient
     */
    public function isTransient(): bool
    {
        return $this === self::Transient;
    }
}
