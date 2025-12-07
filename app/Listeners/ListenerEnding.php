<?php

namespace App\Listeners;

use App\Events\BidPlaced;
use App\Events\EndingAuction;
use App\Models\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ListenerEnding implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Handle the event.
     */
    public function handle(EndingAuction $event): void
    {
      
        $exists = Notification::where('user_id', $event->user_to_be_notified)
            ->where('auction_id', $event->auction->id)
            ->where('type', 'ending') 
            ->exists();

       
        if ($exists) {
            return;
        }

        
        Notification::create([
            'user_id'      => $event->user_to_be_notified->id,
            'type'         => 'ending',
            'auction_id'   => $event->auction->id,
            'is_read'      => false,
            'created_date' => now(),
        ]);
    }
}