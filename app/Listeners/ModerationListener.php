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
        $book = $event->book;

        $result = app(ModerationService::class)
            ->check($book);

        if ($result['passed']) {

            $book->update([
                'status' => BookStatus::UNDER_REVIEW
            ]);

            event(new ModerationPassed($book));

        } else {

            ModerationLog::create([
                'book_id' => $book->id,
                'status' => 'failed',
                'remarks' => implode(', ', $result['words']),
            ]);
        }
    }
}
