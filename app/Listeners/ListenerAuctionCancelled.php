<?php

namespace App\Listeners;

use App\Events\AuctionWinner;
use App\Events\BidPlaced;
use App\Events\EndingAuction;
use App\Models\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ListenerAuctionCancelled implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Handle the event.
     */
    public function handle(AuctionWinner $event): void
    {
      
        $auction = $event->auction;
        
        $receiverId = $auction->owner_id;


        Notification::create([
            'user_id'      => $receiverId,        
            'type'         => 'cancel',          
            'auction_id'   => $auction->id,  
            'is_read'      => false,
            'created_date' => now(),
        ]);
    }
}