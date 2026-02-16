<?php

namespace Tridi\LaravelPostgresRanges\Ranges;

use Illuminate\Contracts\Database\Eloquent\Castable;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Grammar;
use JsonSerializable;
use Livewire\Wireable;
use Stringable;
use Tridi\LaravelPostgresRanges\Bounds\LowerBound;
use Tridi\LaravelPostgresRanges\Bounds\UpperBound;
use Illuminate\Contracts\Database\Query\Expression as ExpressionContract;

/**
 * @template TData
 *
 * @var TData|string|null $from
 * @var TData|string|null $to
 */
abstract class Range implements JsonSerializable, Wireable, Castable, ExpressionContract, Stringable, Arrayable
{
    public function __construct(
        private $from = null,
        private $to = null,
        private LowerBound $lowerBound = LowerBound::Inclusive,
        private UpperBound $upperBound = UpperBound::Exclusive
    ) {
        if ($this->from !== null) {
            $this->from = $this->transform($this->from);
        }

        if ($this->to !== null) {
            $this->to = $this->transform($this->to);
        }

        if ($this->from === null) {
            $this->lowerBound = LowerBound::Exclusive;
        }

        if ($this->to === null) {
            $this->upperBound = UpperBound::Exclusive;
        }
    }

    public static function inclusive($from, $to): static {
        return new static(
            $from,
            $to,
            LowerBound::Inclusive,
            UpperBound::Inclusive
        );
    }

    public static function exclusive($from, $to): static {
        return new static(
            $from,
            $to,
            LowerBound::Exclusive,
            UpperBound::Exclusive
        );
    }

    /**
     * @return TData|null
     */
    public function from(): mixed {
        return $this->from;
    }

    /**
     * @return TData|null
     */
    public function lower(): mixed {
        return $this->from();
    }

    /**
     * @return TData|null
     */
    public function to(): mixed {
        return $this->to;
    }

    /**
     * @return TData|null
     */
    public function upper(): mixed {
        return $this->to();
    }

    public function lowerBound(): LowerBound {
        return $this->lowerBound;
    }

    public function upperBound(): UpperBound {
        return $this->upperBound;
    }

    public function __toString() {
        return sprintf(
            '%s"%s","%s"%s',
            $this->lowerBound->value,
            $this->from(),
            $this->to(),
            $this->upperBound->value
        );
    }

    public function jsonSerialize(): string {
        return json_encode([
            'from' => $this->from(),
            'to' => $this->to()
        ]);
    }

    public function toArray(): array {
        return [
            $this->from(),
            $this->to(),
        ];
    }

    public function getValue(Grammar $grammar): string {
        return "'$this'::{$this->sqlTypeCast()}";
    }

    public function toLivewire(): array {
        return [
            'from' => $this->from,
            'to' => $this->to
        ];
    }

    public static function fromLivewire($value): static {
        $from = $value['from'];
        $to = $value['to'];

        return new static($from, $to, LowerBound::Inclusive, UpperBound::Inclusive);
    }

    /**
     * @return TData|null
     */
    protected abstract function transform($value): mixed;

    /**
     * @return string Typename of range in Postgres
     *
     * @example daterange for DateRange, tsrange for DateTimeRange, etc.
     */
    protected abstract function sqlTypeCast(): string;
}
