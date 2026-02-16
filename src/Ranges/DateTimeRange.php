<?php

namespace Tridi\LaravelPostgresRanges\Ranges;

use Carbon\CarbonImmutable;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Contracts\Database\Eloquent\CastsInboundAttributes;
use Tridi\LaravelPostgresRanges\Casts\DateTimeRangeCast;
use Tridi\LaravelPostgresRanges\Traits\TimeableRange;

/**
 * @template-extends Range<CarbonImmutable>
 */
class DateTimeRange extends Range
{
    use TimeableRange;

    /**
     * @inheritDoc
     */
    public static function castUsing(array $arguments): CastsAttributes|string|CastsInboundAttributes {
        return DateTimeRangeCast::class;
    }

    protected function transform(string $value): CarbonImmutable|null {
        return CarbonImmutable::parse($value);
    }

    protected function sqlTypeCast(): string {
        return 'tsrange';
    }
}
