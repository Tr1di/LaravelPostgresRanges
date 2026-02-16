<?php

namespace Tridi\LaravelPostgresRanges\Ranges;

use Carbon\CarbonImmutable;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Contracts\Database\Eloquent\CastsInboundAttributes;
use Tridi\LaravelPostgresRanges\Casts\DateRangeCast;
use Tridi\LaravelPostgresRanges\Traits\TimeableRange;
use function Webmozart\Assert\Tests\StaticAnalysis\null;

/**
 * @template-extends Range<CarbonImmutable>
 */
class DateRange extends CanonicalRange
{
    use TimeableRange;

    public static function castUsing(array $arguments): CastsAttributes|string|CastsInboundAttributes {
        return DateRangeCast::class;
    }

    protected function transform($value): CarbonImmutable|null {
        return CarbonImmutable::parse($value);
    }

    /**
     * @param CarbonImmutable|null $value
     *
     * @return CarbonImmutable|null
     */
    protected function increment($value): CarbonImmutable|null {
        return $value?->addDay();
    }

    /**
     * @param CarbonImmutable|null $value
     *
     * @return CarbonImmutable|null
     */
    protected function decrement($value): CarbonImmutable|null {
        return $value?->subDay();
    }

    protected function sqlTypeCast(): string {
        return "daterange";
    }
}
