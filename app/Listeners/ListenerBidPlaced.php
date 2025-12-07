<?php

namespace App\Listeners;

use App\Events\BidPlaced;
use App\Models\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ListenerBidPlaced implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Handle the event.
     */
    public function handle(BidPlaced $event): void
    {
      
        $auction = $event->auction;
        
        $receiverId = $auction->owner_id;


        Notification::create([
            'user_id'      => $receiverId,        
            'type'         => 'new-bid',          
            'auction_id'   => $auction->id,  
            'bid_id'       => $event->bid_id,   
            'is_read'      => false,
            'created_date' => now(),
        ]);
    }
}