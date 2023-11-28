<?php

declare(strict_types=1);

use Tactics\Monad\Context\Context;
use Tactics\Monad\Context\ContextCollection;
use \Tactics\Monad\Either;
use \Tactics\Monad\Either\Failure;
use Tactics\Monad\Trace\TraceCommon;

/**
 * Functional wrapper around Json serializer.
 */
final class Example
{
    public function __invoke(Either $result): Either
    {
        return $result->bind(
            function (object $object) use ($result) {
                try {
                    $first = $object->item->first;
                    return $result->lift($first);
                } catch (Throwable $e) {
                    $contexts = ContextCollection::empty();
                    $contexts = $contexts->add(ErrorContext::from());
                    return Failure::dueTo(
                        message: 'message',
                        code: 0,
                        trace: TraceCommon::from('extra trace', time()),
                        traces: $result->traces(),
                        contexts: $contexts
                    );
                }
            }
        );
    }
}


final class ErrorContext implements Context
{
    private function __construct(){}

    public static function from(): ErrorContext {
        return new ErrorContext();
    }
}
