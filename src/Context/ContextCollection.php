<?php

declare(strict_types=1);

namespace Tactics\Monad\Context;

use Generator;
use Tactics\Monad\Monads\Optional\None;
use Tactics\Monad\Monads\Optional\Some;
use Tactics\Monad\Optional;

final class ContextCollection implements Contexts
{
    protected array $contexts = [];

    private function __construct()
    {
    }

    public static function empty(): self
    {
        return new self();
    }

    public function get(string $class): Optional
    {
        return $this->contexts[$class] ? Some::of($this->contexts[$class]) : None::of();
    }

    public function add(Context $context): ContextCollection
    {
        $new = clone ($this);
        $contexts = $this->contexts;
        $contexts[get_class($context)] = $context;
        $new->contexts = $contexts;
        return $new;
    }

    public function remove(string $class): ContextCollection
    {
        $new = clone ($this);
        $contexts = $this->contexts;
        if (isset($contexts[$class])) {
            unset($contexts[$class]);
        }
        $new->contexts = $contexts;
        return $new;
    }

    /**
     * @return Generator<Context>
     */
    public function getIterator(): Generator
    {
        foreach ($this->contexts as $context) {
            yield $context;
        }
    }
}
