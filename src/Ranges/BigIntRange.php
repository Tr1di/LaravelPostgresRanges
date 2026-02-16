<?php

namespace Tridi\LaravelPostgresRanges\Ranges;

use Tridi\LaravelPostgresRanges\Ranges\Range;

class BigIntRange extends CanonicalRange
{
    /**
     * @inheritDoc
     */
    public static function castUsing(array $arguments) {
        // TODO: Implement castUsing() method.
    }

    public function toCanonical(): BigIntRange {
        // TODO: Implement toCanonical() method.
    }

    /**
     * @inheritDoc
     */
    protected function increment($value): mixed {
        // TODO: Implement increment() method.
    }

    /**
     * @inheritDoc
     */
    protected function decrement($value): mixed {
        // TODO: Implement decrement() method.
    }

    protected function transform(string $value): mixed {
        // TODO: Implement transform() method.
    }

    protected function sqlTypeCast(): string {
        // TODO: Implement sqlTypeCast() method.
    }
}
