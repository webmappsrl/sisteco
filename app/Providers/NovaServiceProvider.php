<?php

namespace App\Providers;

use App\Models\Poi;
use App\Nova\Metrics\AreaLayerCount;
use App\Nova\Metrics\AreaLayersPerDay;
use App\Nova\Metrics\AreaLayersPerName;
use App\Nova\Metrics\PoiLayerCount;
use App\Nova\Metrics\PoiLayersPerName;
use App\Nova\Metrics\TrackLayerCount;
use Illuminate\Support\Facades\Gate;
use Laravel\Nova\Cards\Help;
use Laravel\Nova\Nova;
use Laravel\Nova\NovaApplicationServiceProvider;

class NovaServiceProvider extends NovaApplicationServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
        Nova::style('sis_style',asset('../css/sis_style.css'));

    }

    /**
     * Register the Nova routes.
     *
     * @return void
     */
    protected function routes()
    {
        Nova::routes()
                ->withAuthenticationRoutes()
                ->withPasswordResetRoutes()
                ->register();
    }

    /**
     * Register the Nova gate.
     *
     * This gate determines who can access Nova in non-local environments.
     *
     * @return void
     */
    protected function gate()
    {
        Gate::define('viewNova', function ($user) {
            return in_array($user->email, [
                //
            ]);
        });
    }

    /**
     * Get the cards that should be displayed on the default Nova dashboard.
     *
     * @return array
     */
    protected function cards()
    {
        return [

            new PoiLayerCount(),
            new TrackLayerCount(),
            new AreaLayerCount(),
            (new AreaLayersPerDay())->width('1/2'),
            (new AreaLayersPerName())->width('1/2'),
        ];
    }

    /**
     * Get the extra dashboards that should be displayed on the Nova dashboard.
     *
     * @return array
     */
    protected function dashboards()
    {
        return [];
    }

    /**
     * Get the tools that should be listed in the Nova sidebar.
     *
     * @return array
     */
    public function tools()
    {
        return [];
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
