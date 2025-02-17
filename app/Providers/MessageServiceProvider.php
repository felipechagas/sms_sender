<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class MessageServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            'App\Repository\MessageRepositoryInterface',
            'App\Repository\MessageRepository'
        );
    }
}
