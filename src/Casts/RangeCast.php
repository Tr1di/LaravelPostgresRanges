<?php

namespace Tridi\LaravelPostgresRanges\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;
use Tridi\LaravelPostgresRanges\Bounds\LowerBound;
use Tridi\LaravelPostgresRanges\Bounds\UpperBound;
use Tridi\LaravelPostgresRanges\Ranges\CanonicalRange;
use Tridi\LaravelPostgresRanges\Ranges\Range;

/**
 * @template TGet of Range
 * @template TSet
 *
 * @implements CastsAttributes<TGet, TSet>
 */
abstract class RangeCast implements CastsAttributes
{
    /**
     * @param string|null $initialType
     */
    public function __construct(
        protected string|null $initialType = null,
    ) {}

    /**
     * Transform the attribute from the underlying model values.
     *
     * @param  string|null  $value
     * @param  array<string, mixed>  $attributes
     * @return TGet|null
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): ?Range {
        if ($value === null) {
            return null;
        }

        $matches = $this->parse($value);
        if (empty($matches)) {
            return null;
        }

        return $this->factoryInternal($matches);
    }

    /**
     * Transform the attribute to its underlying model values.
     *
     * @param  TSet|null  $value
     * @param  array<string, mixed>  $attributes
     * @return null[]|string[]
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): array {
        return [
            $key => ($value !== null) ? (string) $value : null,
        ];
    }

    /**
     * @return array{string|null, string|null, LowerBound, UpperBound}|array{}
     */
    protected function parse(string $value): array {
        if (preg_match('/([\[(])"?(.*?)"?,"?(.*?)"?([])])/', $value, $matches) !== 1) {
            return [];
        }

        /** @var array{string, '['|'(', string, string, ']'|')'} $matches */
        if (strtolower($matches[2]) === '-infinity' || strtolower($matches[2]) === 'infinity') {
            $matches[2] = null;
        }

        if (strtolower($matches[3]) === '-infinity' || strtolower($matches[3]) === 'infinity') {
            $matches[3] = null;
        }

        return [
            $matches[2] !== '' ? $matches[2] : null,
            $matches[3] !== '' ? $matches[3] : null,
            LowerBound::from($matches[1]),
            UpperBound::from($matches[4]),
        ];
    }

    /**
     * @param  array{string|null, string|null, LowerBound, UpperBound}  $matches
     * @return TGet
     */
    private function factoryInternal(array $matches): Range {
        $range = $this->factory($matches);

        if ($range instanceof CanonicalRange) {
            return match ($this->initialType) {
                'exclusive' => $range->toExclusive(),
                'inclusive' => $range->toInclusive(),
                'canonical' => $range->toCanonical(),
                null => $range,
                default => throw new InvalidArgumentException(
                    "InitialType must be exclusive, inclusive, canonical, or null, \"$this->initialType\" provided"
                )
            };
        }

        return $range;
    }

    /**
     * @param  array{string|null, string|null, LowerBound, UpperBound}  $matches
     * @return TGet
     */
    public function factory(array $matches): Range {
        return new ($this->getRangeClass())($matches[0], $matches[1], $matches[2], $matches[3]);
    }

    /**
     * @return class-string<TGet>
     */
    protected abstract function getRangeClass(): string;
}
