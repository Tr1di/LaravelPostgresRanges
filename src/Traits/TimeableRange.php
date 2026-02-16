<?php

namespace Tridi\LaravelPostgresRanges\Traits;

use Carbon\CarbonImmutable;

trait TimeableRange
{
    public function start(): CarbonImmutable|null {
        return $this->from();
    }

    public function end(): CarbonImmutable|null {
        return $this->to();
    }
}
