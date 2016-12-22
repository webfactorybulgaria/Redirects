<?php

namespace TypiCMS\Modules\Redirects\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use TypiCMS\Modules\Core\Shells\Facades\TypiCMS;
use TypiCMS\Modules\Core\Shells\Observers\FileObserver;
use TypiCMS\Modules\Core\Shells\Observers\SlugObserver;
use TypiCMS\Modules\Core\Shells\Services\Cache\LaravelCache;
use TypiCMS\Modules\Redirects\Shells\Models\Redirect;
use TypiCMS\Modules\Redirects\Shells\Repositories\CacheDecorator;
use TypiCMS\Modules\Redirects\Shells\Repositories\EloquentRedirect;

class ModuleProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../database' => base_path('database'),
        ], 'migrations');

        AliasLoader::getInstance()->alias(
            'Redirects',
            'TypiCMS\Modules\Redirects\Shells\Facades\Facade'
        );

        // Observers
        Redirect::observe(new FileObserver());
    }

    public function register()
    {
        $app = $this->app;

        $app->bind('TypiCMS\Modules\Redirects\Shells\Repositories\RedirectInterface', function (Application $app) {
            $repository = new EloquentRedirect(new Redirect());
            if (!config('typicms.cache')) {
                return $repository;
            }
            $laravelCache = new LaravelCache($app['cache'], 'redirects', 10);

            return new CacheDecorator($repository, $laravelCache);
        });
    }
}
