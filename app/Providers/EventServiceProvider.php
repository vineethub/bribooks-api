<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Events\BookCreated;
use App\Events\BookSubmitted;
use App\Events\BookPublished;

use App\Listeners\AnalyticsListener;
use App\Listeners\ModerationListener;
use App\Listeners\NotificationListener;

class EventServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    protected $listen = [
        BookCreated::class => [
            AnalyticsListener::class,
        ],

        BookSubmitted::class => [
            ModerationListener::class,
        ],

        BookPublished::class => [
            NotificationListener::class,
        ],
    ];
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
