<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\BookApproved;

class BookApprovedListener
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
    public function handle(BookApproved $event): void
    {
        logger()->info('Book Approved', [
            'book_id' => $event->book->id,
            'title' => $event->book->title,
        ]);
    }
}
