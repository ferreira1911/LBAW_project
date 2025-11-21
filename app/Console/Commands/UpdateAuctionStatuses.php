<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Auction;
use Carbon\Carbon;

class UpdateAuctionStatuses extends Command
{
    protected $signature = 'app:update-auction-statuses';
    protected $description = 'Automatically update auction statuses based on start and end dates';

    public function handle()
    {
        $now = Carbon::now();

        // --- Activate auctions ---
        $activated = Auction::where('start_date', '<=', $now)
            ->where('status', '=', 'Pending')
            ->where('status', '!=', 'Active')
            ->update(['status' => 'Active']);

        // --- Mark auctions as ending soon (15 min left) ---
        $ending = Auction::where('end_date', '<=', $now->copy()->addMinutes(15))
            ->where('end_date', '>', $now) // still running
            ->where('status', '=', 'Active')
            ->where('status', '!=', 'Ending')
            ->update(['status' => 'Ending']);

        // --- End auctions ---
        $ended = Auction::where('end_date', '<=', $now)
            ->where('status', '=', 'Ending')
            ->where('status', '!=', 'Ended')
            ->update(['status' => 'Ended']);

        $this->info("Updated: {$activated} activated, {$ending} ending, {$ended} ended.");
    }
}
