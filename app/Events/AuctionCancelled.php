<?php
namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use App\Models\Bid;

class AuctionCancelled implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    public $user_to_be_notified;
    
    public $auction;

    public function __construct($user_to_be_notified, $auction) {
        
        $this->auction = $auction;
        $this->user_to_be_notified = $user_to_be_notified;
        $this->message = 'You have cancelled' . $auction->title;
    }

    public function broadcastOn() {
        return new PrivateChannel('user.' . $this->user_to_be_notified['id']);
    }

    public function broadcastAs() {
        return 'notifications';
    }

    public function broadcastWith()
    {
        return [
            'message' => $this->message,
        ];
    }
}