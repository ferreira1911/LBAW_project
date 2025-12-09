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

class NewMessage implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    public $user_to_be_notified;
    

    public function __construct($user_to_be_notified, $message) {
        
        $this->user_to_be_notified = $user_to_be_notified;
        $this->message = $message;
    }

    public function broadcastOn() {
        return 'presense-user.' . $this->user_to_be_notified['id'];
    }

    public function broadcastAs() {
        return 'new-message';
    }

    public function broadcastWith()
    {
        return [
            'message' => $this->message,
        ];
    }
}