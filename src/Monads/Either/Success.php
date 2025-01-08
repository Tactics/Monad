<?php

declare(strict_types=1);

namespace Tactics\Monad\Monads\Either;

use Tactics\Monad\Context\Context;
use Tactics\Monad\Context\ContextCollection;
use Tactics\Monad\Context\Contexts;
use Tactics\Monad\Either;
use Tactics\Monad\Fault;
use Tactics\Monad\Optional;
use Tactics\Monad\Trace\Trace;
use Tactics\Monad\Trace\TraceCollection;
use Tactics\Monad\Trace\Traces;
use Throwable;

final class Success implements Either
{
    private function __construct(
        protected readonly mixed $value,
        protected Traces $traces,
        protected Contexts $contexts
    ) {
    }

    public static function of(mixed $value, ?Traces $traces = null, ?Contexts $contexts = null): Success
    {
        return new self(
            value: $value,
            traces: $traces ?? TraceCollection::empty(),
            contexts: $contexts ?? ContextCollection::empty()
        );
    }

    public function lift($value): Success
    {
        return new self(
            value: $value,
            traces: $this->traces,
            contexts: $this->contexts
        );
    }

    public function fail(Fault $fault, Trace|null $trace = null): Failure
    {
        // Keep only persistent contexts
        $persistentContexts = $this->contexts->filter(function (Context $context) {
            return $context->type()->isPersistent();
        });

        return Failure::dueTo(
            message: $fault->message,
            code: $fault->code,
            previous: $fault->previous,
            trace: $trace,
            traces: $this->traces,
            contexts: $persistentContexts
        );
    }

    public function bind(callable $fn): Success|Failure
    {
        return $fn($this->value);
    }

    public function map(callable $fn): Success
    {
        return self::of(
            value: $fn($this->value),
            traces: $this->traces,
            contexts: $this->contexts
        );
    }

    public function unwrap(): mixed
    {
        return $this->value;
    }

    public function withTrace(Trace $trace): Success
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

    public function withContext(Context $context): Success
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

    public function clearContext(string $class): Success
    {
        $new = clone $this;
        $contexts = $this->contexts->remove($class);
        $new->contexts = $contexts;
        return $new;
    }
}
