<?php

namespace App\Listeners;

use App\Events\BidPlaced;
use App\Events\EndedAuction;
use App\Models\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ListenerAuctionBought implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Handle the event.
     */
    public function handle(EndedAuction $event): void
    {
        $auction = $event->auction;
        
        $receiverId = $event->user_to_be_notified->id;
        
        
        Notification::create([
            'user_id'      => $receiverId,        
            'type'         => 'auction-bought',          
            'auction_id'   => $auction->id,   
            'is_read'      => false,
            'created_date' => now(),
        ]);
        
    }
}