<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        \App\Models\Product::observe(\App\Observers\ZivoProductObserver::class);
        foreach ([\App\Models\Size::class, \App\Models\Media::class, \App\Models\Category::class, \App\Models\Option::class] as $model) {
            $model::observe(\App\Observers\ZivoRelatedProductObserver::class);
        }
    }
}
