<?php

namespace Tridi\LaravelPostgresRanges\Casts;

use Tridi\LaravelPostgresRanges\Ranges\DateRange;

/**
 * @template TSet
 * @template-extends RangeCast<DateRange, TSet>
 */
class DateRangeCast extends RangeCast
{
    protected function getRangeClass(): string {
        return DateRange::class;
    }
}
