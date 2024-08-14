<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;
use Laravel\Fortify\Features;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Defines the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     */
    public function share(Request $request): array
    {
        return array_merge(parent::share($request), [

            'auth' => function () use ($request) {
                return [
                    'user' => $request->user() ? [
                        'id' => $request->user()->id,
                        'email' => $request->user()->email,
                        'full_name' => $request->user()->full_name,
                        'profile_photo_url' => 'https://www.gravatar.com/avatar/' . md5($request->user()->email),
                        'two_factor_enabled' => Features::enabled(Features::twoFactorAuthentication())
                            && ! is_null($request->user()->two_factor_secret),
                    ] : null,
                ];
            },

            'flash' => function () use ($request) {
                return [
                    'success' => $request->session()->get('success'),
                    'error' => $request->session()->get('error'),
                    'alert' => $request->session()->get('alert'),
                ];
            },
            'shared_values' => function () {
                return [
                    'app_version' => config('app.version'),
                    'app_name' => config('app.name'),
                ];
            },
        ]);
    }
}
