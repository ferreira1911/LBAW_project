<?php

namespace App\Listeners;

use App\Events\AuctionWinner;
use App\Events\BidPlaced;
use App\Events\EndingAuction;
use App\Models\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ListenerAuctionWinner implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Handle the event.
     */
    public function handle(AuctionWinner $event): void
    {
      
        $auction = $event->auction;
        
        


        Notification::create([
            'user_id'      => $event->user_to_be_notified->id,        
            'type'         => 'winner',          
            'auction_id'   => $auction->id,  
            'is_read'      => false,
            'created_date' => now(),
        ]);
    }
}