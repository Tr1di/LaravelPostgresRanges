<?php

namespace Tridi\LaravelPostgresRanges;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Tridi\LaravelPostgresRanges\Macros\BuilderRanges;

class PostgresRangesServiceProvider extends ServiceProvider
{
    public function register(): void {
        EloquentBuilder::mixin(new BuilderRanges());
    }
}
