<?php

namespace Tridi\LaravelPostgresRanges\Ranges;

use Illuminate\Support\Optional;
use Tridi\LaravelPostgresRanges\Casts\RangeCast;

class IntRange extends CanonicalRange
{
    /**
     * @inheritDoc
     */
    public static function castUsing(array $arguments) {
        return new class extends RangeCast {
            protected function getRangeClass(): string {
                return IntRange::class;
            }
        };
    }

    protected function transform($value): int {
        return (int)$value;
    }

    /**
     * @inheritDoc
     */
    protected function increment($value): int|Optional {
        return optional($value, static fn($value): int => $value + 1);
    }

    /**
     * @inheritDoc
     */
    protected function decrement($value): int|Optional {
        return optional($value, static fn($value): int => $value - 1);
    }

    protected function sqlTypeCast(): string {
        return "int4range";
    }
}
