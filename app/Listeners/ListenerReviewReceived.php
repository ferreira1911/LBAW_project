<?php

namespace App\Listeners;

use App\Events\ReviewReceived;
use App\Events\EndedAuction;
use App\Models\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ListenerReviewReceived implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Handle the event.
     */
    public function handle(ReviewReceived $event): void
    {
        $auction = $event->auction;
        
        $receiverId = $event->user_to_be_notified->id;
        
        
        Notification::create([
            'user_id'      => $receiverId,        
            'type'         => 'review',          
            'auction_id'   => $auction->id,
            'review_id'    => $event->review->id,
            'is_read'      => false,
            'created_date' => now(),
        ]);
    }
}