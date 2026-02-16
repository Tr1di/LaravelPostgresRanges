<?php

namespace Tridi\LaravelPostgresRanges\Bounds;

enum LowerBound : string
{
    case Inclusive = '[';
    case Exclusive = '(';

    public function isInclusive() {
        return $this === self::Inclusive;
    }

    public function isExclusive() {
        return $this === self::Exclusive;
    }
}
