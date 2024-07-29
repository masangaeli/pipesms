<?php

namespace App\Providers;

use View;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
          //Second Way of Forcing SSL Scheme
          URL::forceScheme('https');

          //Forcing SSL
          if (env('APP_ENV') == 'production') {
             $this->app['request']->server->set('HTTPS', true);
          }
  
          //Schema Default String Length
          Schema::defaultStringLength(191);
  
          //Sharing to All Views
          View::share([
              'appTitle' => 'Pipe SMS',
          ]);
  
    }
}
