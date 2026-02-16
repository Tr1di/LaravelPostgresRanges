<?php

namespace Tridi\LaravelPostgresRanges\Casts;

use Tridi\LaravelPostgresRanges\Ranges\DateTimeRange;

/**
 * @template TSet
 * @template-extends RangeCast<DateTimeRange, TSet>
 */
class DateTimeRangeCast extends RangeCast
{
    protected function getRangeClass(): string {
        return DateTimeRange::class;
    }
}
