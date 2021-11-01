<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Laravel\Nova\Cards\Help;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Nova;
use Laravel\Nova\NovaApplicationServiceProvider;
use Laravel\Nova\Panel;
use OptimistDigital\NovaSettings\NovaSettings;
use KABBOUCHI\LogsTool\LogsTool;

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

        NovaSettings::addSettingsFields([
            Panel::make('Site', [
                Text::make(__('Name')),

                Image::make(__('Logo'))
                    ->prunable(),
            ]),
        ]);
    }

    /**
     * Register the Nova routes.
     *
     * @return void
     */
    protected function routes()
    {
        Nova::routes();
//                ->withAuthenticationRoutes()
//                ->withPasswordResetRoutes()
//                ->register();
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
            if ($user->can('viewNova')) {
                return true;
            }
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
//            new Help,
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
        return [
            // https://github.com/optimistdigital/nova-settings
            (new NovaSettings)->canSee(function () {
                if (Auth::user()->can('viewSettings')) {
                    return true;
                }
            }),
            // https://github.com/KABBOUCHI/nova-logs-tool
            (new LogsTool)->canSee(function () {
                if (Auth::user()->can('ViewNovaLogs')) {
                    return true;
                }
            }),
        ];
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
