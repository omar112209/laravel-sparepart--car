<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        if (config('app.env') === 'production') {
            URL::forceScheme('https');

            $this->app->booted(function () {
                if ($this->app->runningInConsole()) {
                    return;
                }

                $request = $this->app->make('request');
                if ($request->server->has('HTTP_HOST')) {
                    URL::forceRootUrl($request->getSchemeAndHttpHost());
                }
            });
        }
    }
}
