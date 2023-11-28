<?php

declare(strict_types=1);

namespace Tactics\Monad\Either;

use Tactics\Monad\Either;
use Tactics\Monad\Trace\Trace;
use Tactics\Monad\Trace\TraceCollection;
use Tactics\Monad\Trace\Traces;
use ValueError;

final class Failure implements Either
{

    private function __construct(
        protected readonly string $message,
        protected readonly string|int $code,
        protected Traces $traces
    ) {
    }

    private static function dueTo(
        string $message,
        string|int $code = 0,
        ?Trace $trace = NULL,
        ?Traces $traces = NULL
    ) : Failure
    {
        // Add Failure traces as last item.
        $traces = $traces ?? TraceCollection::empty();
        if ($trace) {
            $traces->add($trace);
        }

        return new Failure(
            $message,
            $code,
            $traces
        );
    }

    public function bind(callable $fn): Failure
    {
        return $this;
    }

    public function unwrap(): mixed
    {
        throw new ValueError('Value of Failure can not be unwrapped');
    }

    public function map(callable $fn): Failure
    {
        return $this;
    }

    public function lift(mixed $value): Failure
    {
        return $this;
    }
}




