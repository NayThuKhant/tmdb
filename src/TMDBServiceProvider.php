<?php

namespace NayThuKhant\TMDB;

use Illuminate\Support\ServiceProvider;

class TMDBServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->publishes([
            __DIR__."/config/tmdb.php" => config_path('tmdb.php')
        ], 'tmdb');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->mergeConfigFrom(__DIR__."/config/tmdb.php", 'tmdb');
    }
}
