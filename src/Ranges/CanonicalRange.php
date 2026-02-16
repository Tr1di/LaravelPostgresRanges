<?php

namespace Tridi\LaravelPostgresRanges\Ranges;

use Tridi\LaravelPostgresRanges\Bounds\LowerBound;
use Tridi\LaravelPostgresRanges\Bounds\UpperBound;

/**
 * @template TData
 */
abstract class CanonicalRange extends Range
{
    public function toInclusive(): static {
        if ($this->lowerBound()->isExclusive()) {
            $from = $this->increment($this->from());
            $lowerBound = LowerBound::Inclusive;
        }

        if ($this->upperBound()->isExclusive()) {
            $to = $this->decrement($this->to());
            $upperBound = UpperBound::Inclusive;
        }

        return new static(
            $from ?? $this->from(),
            $to ?? $this->to(),
            $lowerBound ?? $this->lowerBound(),
            $upperBound ?? $this->upperBound()
        );
    }

    public function toExclusive(): static {
        if ($this->lowerBound()->isInclusive()) {
            $from = $this->decrement($this->from());
            $lowerBound = LowerBound::Exclusive;
        }

        if ($this->upperBound()->isInclusive()) {
            $to = $this->increment($this->to());
            $upperBound = UpperBound::Exclusive;
        }

        return new static(
            $from ?? $this->from(),
            $to ?? $this->to(),
            $lowerBound ?? $this->lowerBound(),
            $upperBound ?? $this->upperBound()
        );
    }

    public function toCanonical(): static {
        if ($this->lowerBound()->isExclusive()) {
            $from = $this->increment($this->from());
            $lowerBound = LowerBound::Inclusive;
        }

        if ($this->upperBound()->isInclusive()) {
            $to = $this->increment($this->to());
            $upperBound = UpperBound::Exclusive;
        }

        return new static(
            $from ?? $this->from(),
            $to ?? $this->to(),
            $lowerBound ?? $this->lowerBound(),
            $upperBound ?? $this->upperBound()
        );
    }

    /**
     * @param TData|null $value
     *
     * @return TData|null
     */
    protected abstract function increment($value): mixed;

    /**
     * @param TData|null $value
     *
     * @return TData|null
     */
    protected abstract function decrement($value): mixed;
}
