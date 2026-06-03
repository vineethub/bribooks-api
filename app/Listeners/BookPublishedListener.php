<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\BookPublished;

class BookPublishedListener
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
    public function handle(BookPublished $event): void
    {
        logger()->info('Book Approved', [
            'book_id' => $event->book->id,
            'title' => $event->book->title,
        ]);
    }
}
