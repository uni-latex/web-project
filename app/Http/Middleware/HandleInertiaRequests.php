<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;
use Inertia\Middleware;
use Laravel\Fortify\Features;
use Laravel\Jetstream\Jetstream;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function version(Request $request)
    {
        return parent::version($request);
    }

    /**
     * Defines the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function share(Request $request)
    {
        return array_merge(parent::share($request), [
            'app' => [
                'name' => nova_get_setting('name', config('web.name')),
                'logo' => nova_get_setting('logo', config('web.logo')),
                'showToken' => config('web.show_token'),
            ],
            'admin' => function () use ($request) {
                if (! $request->user() ) {
                    return;
                }

//                if (! $request->user()->hasPermissionTo('viewNova') && ! $request->user()->admin() ) {
//                    return;
//                }

                return [
                    'url' => config('nova.path') . "/dashboards/main",
                    'name' => "Admin",
                ];
            },
            'user' => function () use ($request) {
                if (! $request->user()) {
                    return;
                }

                return array_merge(
                    $request->user()->only('name', 'email'),
                    [
                        'two_factor_enabled' => ! is_null($request->user()->two_factor_secret),
                    ],
                    [
                        'can' => $request->user()->getPermissionArray(),
                    ]
                );
            },
            'jetstream' => [
                'canManageTwoFactorAuthentication' => Features::canManageTwoFactorAuthentication(),
                'canUpdatePassword' => Features::enabled(Features::updatePasswords()),
                'canUpdateProfileInformation' => Features::canUpdateProfileInformation(),
                'hasAccountDeletionFeatures' => false,
            ],
            'flash' => $this->getFlashMessage($request),
        ]);
    }

    private function getFlashMessage(Request $request)
    {
        return [
            'success' => $request->session()->get('success'),
            'error' => $request->session()->get('error'),
        ];
    }
}
