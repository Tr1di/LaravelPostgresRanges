<?php

namespace Tridi\LaravelPostgresRanges\Ranges;

use Tridi\LaravelPostgresRanges\Ranges\Range;

class BigIntRange extends CanonicalRange
{

    protected function increment($value): mixed {
        // TODO: Implement increment() method.
    }

    protected function decrement($value): mixed {
        // TODO: Implement decrement() method.
    }

    public static function castUsing(array $arguments) {
        // TODO: Implement castUsing() method.
    }

    protected function transform($value): mixed {
        // TODO: Implement transform() method.
    }

    protected function sqlTypeCast(): string {
        // TODO: Implement sqlTypeCast() method.
    }
}
