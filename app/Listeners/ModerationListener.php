<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\BookSubmitted;

class ModerationListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(BookSubmitted $event): void
    {
        logger()->info('Notification Event', [
            'event' => get_class($event),
        ]);
    }
}
