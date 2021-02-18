<?php

namespace Maherelgamil\NovaCalculatedField;

use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Events\ServingNova;
use Laravel\Nova\Nova;
use Illuminate\Support\Facades\Route;

class FieldServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Nova::serving(function (ServingNova $event) {
            Nova::script('nova-calculated-field', __DIR__.'/../dist/js/field.js');
            Nova::style('nova-calculated-field', __DIR__.'/../dist/css/field.css');
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->routesAreCached()) {
            return;
        }

        Route::middleware(['nova'])
            ->namespace('Maherelgamil\NovaCalculatedField\Http\Controllers')
            ->prefix('maherelgamil/nova-calculated-field')
            ->group(__DIR__.'/../routes/api.php');
    }
}
