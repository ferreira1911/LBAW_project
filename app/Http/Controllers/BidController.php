<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Auction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;
use App\Models\Bid;
use App\Models\User;
use App\Events\BidPlaced;
use App\Listeners\ListenerBidPlaced;

class BidController extends Controller
{
    public function store(Request $request, Auction $auction){
        $this->authorize('create', Bid::class);
        
        $request->validate([
            'amount' => 'required|numeric|min:0.01'
        ]);

        $auction->refresh();

        if ($auction->is_buy_now_active && $auction->buy_now_price && $request->amount >= $auction->buy_now_price) {
            return redirect()->route('auctions.show', $auction)
                ->with('failure', 'Your bid cannot equal or exceed the Buy Now price of €' . number_format($auction->buy_now_price, 2) . '. Please use Buy Now instead.');
        }

        try {
            $bid = [
                'user_id' => Auth::id(),
                'amount' => $request->amount,
                'date' => now(),
            ];
            $new_bid = $auction->bids()->create($bid);

            $recipients = $auction->bids()
                ->select('user_id')
                ->distinct()
                ->pluck('user_id');

            $recipients->push($auction->owner_id);

            $uniqueIds = $recipients->unique()->reject(fn($id) => $id === Auth::user()->id);

            $usersToNotify = User::whereIn('id', $uniqueIds)->get();

            
            foreach ($usersToNotify as $recipient) {
                event(new BidPlaced($new_bid->id, Auth::user(), $request->amount, $recipient, $auction));
            }

            return redirect()->route('auctions.show', $auction)->with('success', 'Your bid was placed successfully!');

        } catch (QueryException $e) {
            // Log the full error for debugging
            \Log::error('Bid Error: ' . $e->getMessage());
            \Log::error('Error Code: ' . $e->getCode());
            \Log::error('SQLSTATE: ' . $e->errorInfo[0] ?? 'N/A');
            
            $message = 'An unexpected error has occurred. Please try again later.';
            
            if ($e->getCode() === 'P0001') { 
                $message = 'You were unable to place a bid on this auction. Please check your wallet.';
            } elseif (str_contains($e->getMessage(), 'buy_now') || str_contains($e->getMessage(), 'bid_amount_check')) {
                $message = 'Your bid cannot equal or exceed the Buy Now price. Please use Buy Now instead.';
            }

            // Use 'error' instead of validation errors
            return redirect()->route('auctions.show', $auction)
                ->with('error', $message)
                ->withInput();
        }
    }
    public function index(Request $request)
    {
        $user = Auth::user();
        
        $bids = Bid::where('user_id', $user->id)
            ->with(['auction.images', 'auction.owner'])
            ->orderBy('date', 'desc')
            ->paginate(15);

        
        return view('pages.user.bid-history', [
            'bids' => $bids,
            'user' => $user,
        ]);
    }
}
