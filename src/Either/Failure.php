<?php

declare(strict_types=1);

namespace Tactics\Monad\Either;

use Tactics\Monad\Context\Context;
use Tactics\Monad\Context\ContextCollection;
use Tactics\Monad\Context\Contexts;
use Tactics\Monad\Either;
use Tactics\Monad\Optional;
use Tactics\Monad\Trace\Trace;
use Tactics\Monad\Trace\TraceCollection;
use Tactics\Monad\Trace\Traces;
use ValueError;

final class Failure implements Either
{
    private function __construct(
        protected readonly string $message,
        protected readonly string|int $code,
        protected Traces $traces,
        protected Contexts $contexts
    ) {
    }

    public static function dueTo(
        string $message,
        string|int $code = 0,
        ?Trace $trace = null,
        ?Traces $traces = null,
        ?Contexts $contexts = null
    ): Failure {
        // Add Failure traces as last item.
        $traces = $traces ?? TraceCollection::empty();
        if ($trace) {
            $traces->add($trace);
        }

        return new Failure(
            message: $message,
            code: $code,
            traces: $traces,
            contexts: $contexts ?? ContextCollection::empty()
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

    public function withTrace(Trace $trace): Failure
    {
        $new = clone $this;
        $traces = $this->traces->add($trace);
        $new->traces = $traces;
        return $new;
    }

    public function traces(): Traces
    {
        return $this->traces;
    }

    public function withContext(Context $context): Failure
    {
        $new = clone $this;
        $contexts = $this->contexts->add($context);
        $new->contexts = $contexts;
        return $new;
    }

    public function context(string $class): Optional
    {
        return $this->contexts->get($class);
    }

    public function lift($value): Failure
    {
        return $this;
    }
}
