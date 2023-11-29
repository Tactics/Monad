<?php

declare(strict_types=1);

namespace Tactics\Monad\Monads\Either;

use Exception;
use Tactics\Monad\Context\Context;
use Tactics\Monad\Context\ContextCollection;
use Tactics\Monad\Context\Contexts;
use Tactics\Monad\Either;
use Tactics\Monad\FailureError;
use Tactics\Monad\Optional;
use Tactics\Monad\Trace\Trace;
use Tactics\Monad\Trace\TraceCollection;
use Tactics\Monad\Trace\Traces;
use Throwable;
use ValueError;

final class Failure extends FailureError implements Either
{
    private function __construct(
        protected readonly Throwable $exception,
        protected Traces $traces,
        protected Contexts $contexts
    ) {
        parent::__construct($exception->getMessage(), $exception->getCode(), $exception->getPrevious());
    }

    public static function dueTo(
        string $message,
        int $code,
        Throwable|null $previous = null,
        Trace|null $trace = null,
        Traces|null $traces = null,
        Contexts|null $contexts = null,
    ): Failure {
        $exception = new Exception(
            message: $message,
            code: $code,
            previous: $previous
        );

        // Add Failure traces as last item.
        $traces = $traces ?? TraceCollection::empty();
        if ($trace) {
            $traces->add($trace);
        }

        return new Failure(
            exception: $exception,
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

    public function clearContext(string $class): Failure
    {
        $new = clone $this;
        $contexts = $this->contexts->remove($class);
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

    public function getMessage(): string
    {
        return $this->exception->getMessage();
    }

    public function getCode(): int
    {
        return $this->exception->getCode();
    }

    public function getFile(): string
    {
        return $this->exception->getFile();
    }

    public function getLine(): int
    {
        return $this->exception->getLine();
    }

    public function getTrace(): array
    {
        return $this->exception->getTrace();
    }

    public function getTraceAsString(): string
    {
        return $this->exception->getTraceAsString();
    }

    public function getPrevious(): ?Throwable
    {
        return $this->exception->getPrevious();
    }

    public function __toString()
    {
        return $this->exception->__toString();
    }
}
