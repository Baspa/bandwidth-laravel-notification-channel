<?php

namespace NotificationChannels\BandwidthLaravelNotificationChannel;

use Illuminate\Support\ServiceProvider;
use BandwidthLib\Configuration;

class BandWidthServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        // Bootstrap code here.

        /**
         * Here's some example code we use for the pusher package.

        $this->app->when(Channel::class)
            ->needs(Pusher::class)
            ->give(function () {
                $pusherConfig = config('broadcasting.connections.pusher');

                return new Pusher(
                    $pusherConfig['key'],
                    $pusherConfig['secret'],
                    $pusherConfig['app_id']
                );
            });
         */

        // Set up Bandwidth configuration
        $this->app->singleton(Configuration::class, function ($app) {
            return new Configuration([
                'messagingBasicAuthUserName' => config('services.bandwidth.username'),
                'messagingBasicAuthPassword' => config('services.bandwidth.password'),
            ]);
        });
    }

    /**
     * Register the application services.
     */
    public function register() {}
}
