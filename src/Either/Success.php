<?php

declare(strict_types=1);

namespace Tactics\Monad\Either;

use Tactics\Monad\Context\ContextCollection;
use Tactics\Monad\Context\Contexts;
use Tactics\Monad\Trace\TraceCollection;
use Tactics\Monad\Trace\Traces;
use Tactics\Monad\TraceableEither;

final class Success implements TraceableEither
{

    private function __construct(
        protected readonly mixed $value,
        protected Traces $traces,
        protected Contexts $contexts
    ) {
    }

    public static function of(mixed $value, ?Traces $traces, ?Contexts $contexts): Success
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

    public function bind(callable $fn): Success
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
}
