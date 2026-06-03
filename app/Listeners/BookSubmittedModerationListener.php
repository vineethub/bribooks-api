<?php

namespace App\Listeners;

use App\Events\BookSubmitted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class BookSubmittedModerationListener
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
        logger()->info(
            'Moderation started',
            [
                'book_id' => $event->book->id
            ]
        );
    }
}
