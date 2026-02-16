<?php

namespace Tridi\LaravelPostgresRanges\Bounds;

enum UpperBound : string
{
    case Inclusive = ']';
    case Exclusive = ')';

    public function isInclusive() {
        return $this === self::Inclusive;
    }

    public function isExclusive() {
        return $this === self::Exclusive;
    }
}
