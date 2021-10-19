<?php

namespace App\Providers;

use App\Models\Project;
use App\Nova\Metrics\ProjectLandUsePartitionMetrics;
use App\Nova\Metrics\TotalOwnersValueMetrics;
use App\Nova\Metrics\TotalProjectsValueMetrics;
use App\Nova\Metrics\TotalValueProjectsValueMetrics;
use Illuminate\Support\Facades\Gate;
use Laravel\Nova\Cards\Help;
use Laravel\Nova\Nova;
use Laravel\Nova\NovaApplicationServiceProvider;
use Sisteco\Projectscoverage\Projectscoverage;

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
        //        Nova::style('sis_style', asset('../css/sis_style.css'));
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
                'team@webmapp.it',
                'mario.pestarini@timesis.it',
                'fabrizio.cassi@timesis.it',
                'leonardo.pugliesi@timesis.it',
                'ac.lorenzelli@timesis.it',
                'enrico.quaglino@timesis.it',
                'mauro.piazzi@timesis.it'
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
            new TotalProjectsValueMetrics(),
            new TotalOwnersValueMetrics(),
            new TotalValueProjectsValueMetrics(),
            new Projectscoverage(),
            new ProjectLandUsePartitionMetrics()
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
