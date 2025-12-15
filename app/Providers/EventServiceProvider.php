<?php

namespace App\Providers;

use App\Events\AuctionCancelled;
use App\Events\AuctionWinner;
use App\Events\AuctionBought;
use App\Events\ReviewReceived;
use App\Listeners\ListenerAuctionCancelled;
use App\Listeners\ListenerReviewReceived;
use App\Listeners\ListenerAuctionWinner;
use App\Listeners\ListenerAuctionBought;
use App\Listeners\ListenerEnded;
use App\Events\EndedAuction;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use App\Events\BidPlaced;
use App\Listeners\ListenerBidPlaced;
use App\Events\EndingAuction;
use App\Listeners\ListenerEnding;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        BidPlaced::class => [
            ListenerBidPlaced::class,
        ],
        EndingAuction::class => [
            ListenerEnding::class,
        ],
        EndedAuction::class => [
            ListenerEnded::class,
        ],
        AuctionWinner::class => [
            ListenerAuctionWinner::class,
        ],
        AuctionCancelled::class => [
            ListenerAuctionCancelled::class,
        ],
        ReviewReceived::class => [
            ListenerReviewReceived::class,
        ],
        AuctionBought::class => [
            ListenerAuctionBought::class,
        ],
    ];


    public function boot()
    {
        parent::boot();
    }
}