<?php

namespace App\Console\Commands;
use App\Models\User;
use Illuminate\Console\Command;
use App\Models\Auction;
use App\Events\EndingAuction;
use App\Events\EndedAuction;
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
        $ending = Auction::whereBetween('end_date', [$now, $now->copy()->addMinutes(15)])
            ->where('status', '=', 'Active')
            ->get();

        foreach($ending as $auc){
            $auc->update(['status' => 'Ending']);
            $recipients = $auc->bids()
                ->select('user_id')
                ->distinct()
                ->pluck('user_id');
            $recipients->push($auc->owner_id);

            $uniqueIds = $recipients->unique();

            $usersToNotify = User::whereIn('id', $uniqueIds)->get();

            foreach ($usersToNotify as $recipient) {
                event(new EndingAuction($recipient, $auc));
            }
        }

        // --- End auctions ---
        $ended = Auction::where('end_date', '<=', $now)
            ->whereIn('status', ['Active', 'Ending'])
            ->get();

        foreach($ended as $ea){
            $ea->update(['status' => 'Ended']);
            $recipients = $ea->bids()
                ->select('user_id')
                ->distinct()
                ->pluck('user_id');
            $recipients->push($ea->owner_id);

            $uniqueIds = $recipients->unique();

            $usersToNotify = User::whereIn('id', $uniqueIds)->get();

            foreach ($usersToNotify as $recipient) {
                event(new EndedAuction($recipient, $ea));
            }
        }
            
        $this->info("Updated: {$activated} activated, {$ending} ending, {$ended} ended.");
    }
}


