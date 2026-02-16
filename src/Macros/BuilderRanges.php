<?php

namespace Tridi\LaravelPostgresRanges\Macros;

use Closure;
use Illuminate\Contracts\Database\Query\Expression;
use Illuminate\Database\Eloquent\Builder;
use Tridi\LaravelPostgresRanges\Ranges\Range;

class BuilderRanges
{
    public function whereRangeContains(): Closure {
        return function($column, $value) {
            /** @var Builder $this */
            return $this->whereRange($column, '@>', $value);
        };
    }

    public function whereRangeDoesNotExtendToTheLeftOf(): Closure {
        return function($column, $value) {
            /** @var Builder $this */
            return $this->whereRange($column, '&>', $value);
        };
    }

    public function whereRangeDoesNotExtendToTheRightOf(): Closure {
        return function($column, $value) {
            /** @var Builder $this */
            return $this->whereRange($column, '&<', $value);
        };
    }

    public function whereRangeAdjacentTo(): Closure {
        return function($column, $value) {
            /** @var Builder $this */
            return $this->whereRange($column, '-|-', $value);
        };
    }

    public function whereRangeIsContainedBy(): Closure {
        return function($column, $value) {
            /** @var Builder $this */
            return $this->whereRange($column, '<@', $value);
        };
    }

    public function whereRangeOverlaps(): Closure {
        return function($column, $value) {
            /** @var Builder $this */
            return $this->whereRange($column, '&&', $value);
        };
    }

    public function whereRangeStrictlyLeftOf(): Closure {
        return function($column, $value) {
            /** @var Builder $this */
            return $this->whereRange($column, '<<', $value);
        };
    }

    public function whereRangeStrictlyRightOf(): Closure {
        return function($column, $value) {
            /** @var Builder $this */
            return $this->whereRange($column, '>>', $value);
        };
    }

    public function orWhereRangeContains(): Closure {
        return function($column, $value) {
            /** @var Builder $this */
            return $this->orWhereRange($column, '@>', $value);
        };
    }

    public function orWhereRangeDoesNotExtendToTheLeftOf(): Closure {
        return function($column, $value) {
            /** @var Builder $this */
            return $this->orWhereRange($column, '&>', $value);
        };
    }

    public function orWhereRangeDoesNotExtendToTheRightOf(): Closure {
        return function($column, $value) {
            /** @var Builder $this */
            return $this->orWhereRange($column, '&<', $value);
        };
    }

    public function orWhereRangeAdjacentTo(): Closure {
        return function($column, $value) {
            /** @var Builder $this */
            return $this->orWhereRange($column, '-|-', $value);
        };
    }

    public function orWhereRangeIsContainedBy(): Closure {
        return function($column, $value) {
            /** @var Builder $this */
            return $this->orWhereRange($column, '<@', $value);
        };
    }

    public function orWhereRangeOverlaps(): Closure {
        return function($column, $value) {
            /** @var Builder $this */
            return $this->orWhereRange($column, '&&', $value);
        };
    }

    public function orWhereRangeStrictlyLeftOf(): Closure {
        return function($column, $value) {
            /** @var Builder $this */
            return $this->orWhereRange($column, '<<', $value);
        };
    }

    public function orWhereRangeStrictlyRightOf(): Closure {
        return function($column, $value) {
            /** @var Builder $this */
            return $this->orWhereRange($column, '>>', $value);
        };
    }


    public function whereRange(): Closure {
        return function($column, $operator, $value) {
            /** @var Builder $this */
            if ($value instanceof Range) {
                return $this->where($column, $operator, $value);
            } else {
                // TODO: Хз, потенциально опасно
                return $this->where($column, $operator, "['$value','$value']");
            }
        };
    }

    public function orWhereRange(): Closure {
        return function($column, $operator, $value) {
            /** @var Builder $this */
            if ($value instanceof Range) {
                return $this->orWhere($column, $operator, $value);
            } else {
                // TODO: Хз, потенциально опасно
                return $this->orWhere($column, $operator, "['$value','$value']");
            }
        };
    }
}
