<?php

namespace App\Providers;

use App\Models\AreaLayer;
use App\Models\Poi;
use App\Models\PoiLayer;
use App\Models\TrackLayer;
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
use MyApp\NovaTable\NovaTable;

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
        $pL = PoiLayer::paginate(10);
        $tL = TrackLayer::paginate(10);
        $aL = AreaLayer::paginate(10);

        $header = collect(['Name', 'Description', 'Created_at', 'Updated_at']);


        return [

            new PoiLayerCount(),
            new TrackLayerCount(),
            new AreaLayerCount(),
            (new AreaLayersPerDay())->width('1/2'),
            (new AreaLayersPerName())->width('1/2'),
            (new \Mako\CustomTableCard\CustomTableCard)
                ->header([
                    new \Mako\CustomTableCard\Table\Cell('Name'),
                    new \Mako\CustomTableCard\Table\Cell('Description'),
                    new \Mako\CustomTableCard\Table\Cell('Created_at'),
                    new \Mako\CustomTableCard\Table\Cell('Updated_at'),
                ])
                ->data($pL->map(function ($order)
                {
                    return (new \Mako\CustomTableCard\Table\Row(
                        new \Mako\CustomTableCard\Table\Cell($order['name']),
                        new \Mako\CustomTableCard\Table\Cell($order['description']),
                        new \Mako\CustomTableCard\Table\Cell($order['created_at']),
                        new \Mako\CustomTableCard\Table\Cell($order['updated_at']),
                    ))->viewLink('/resources/maps/');

                })->toArray())
                ->title('Poi Layers')
                ->viewall(['label' => 'View All', 'link' => '/nova/resources/poi-layers']),
            (new \Mako\CustomTableCard\CustomTableCard)
                ->header([
                    new \Mako\CustomTableCard\Table\Cell('Name'),
                    new \Mako\CustomTableCard\Table\Cell('Description'),
                    new \Mako\CustomTableCard\Table\Cell('Created_at'),
                    new \Mako\CustomTableCard\Table\Cell('Updated_at'),
                ])
                ->data($aL->map(function ($order)
                {
                    return (new \Mako\CustomTableCard\Table\Row(
                        new \Mako\CustomTableCard\Table\Cell($order['name']),
                        new \Mako\CustomTableCard\Table\Cell($order['description']),
                        new \Mako\CustomTableCard\Table\Cell($order['created_at']),
                        new \Mako\CustomTableCard\Table\Cell($order['updated_at']),
                    ))->viewLink('/resources/maps/');

                })->toArray())
                ->title('Track Layers')
                ->viewall(['label' => 'View All', 'link' => '/nova/resources/poi-layers']),
            (new \Mako\CustomTableCard\CustomTableCard)
                ->header([
                    new \Mako\CustomTableCard\Table\Cell('Name'),
                    new \Mako\CustomTableCard\Table\Cell('Description'),
                    new \Mako\CustomTableCard\Table\Cell('Created_at'),
                    new \Mako\CustomTableCard\Table\Cell('Updated_at'),
                ])
                ->data($tL->map(function ($order)
                {
                    return (new \Mako\CustomTableCard\Table\Row(
                        new \Mako\CustomTableCard\Table\Cell($order['name']),
                        new \Mako\CustomTableCard\Table\Cell($order['description']),
                        new \Mako\CustomTableCard\Table\Cell($order['created_at']),
                        new \Mako\CustomTableCard\Table\Cell($order['updated_at']),
                    ))->viewLink('/resources/maps/');


                })->toArray())
                ->title('Area Layers')
                ->viewall(['label' => 'View All', 'link' => '/nova/resources/poi-layers'])
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
