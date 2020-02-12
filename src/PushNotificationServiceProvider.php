<?php
namespace JeremyLayson;

use Illuminate\Support\ServiceProvider;

class PushNotificationServiceProvider extends ServiceProvider {

    public function boot()
    {
        // publish other files
        $this->publishes([
            __DIR__ . '/config/laravel-push.php' => config_path('laravel-push.php'),
        ]);
    }

    public function register()
    {
        $this->app->alias('laravel-push', 'JeremyLayson');

    }

    public function provides()
    {
        return ['laravel-push-notification', 'JeremyLayson'];
    }
}