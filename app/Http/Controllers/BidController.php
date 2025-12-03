<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Auction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;
use App\Models\Bid;

class BidController extends Controller
{
    public function store(Request $request, Auction $auction){
        $this->authorize('create', Bid::class);
        
        $request->validate([
            'amount' => 'required|numeric|min:0.01'
        ]);

        try {

            $auction->bids()->create([
                'user_id' => Auth::id(),
                'amount' => $request->amount,
                'date' => now(),
            ]);

            return redirect()->route('auctions.show', $auction)->with('success', 'Your bid was placed successfully!');

        } catch (QueryException $e) {

            $cleanMessage = 'An error occurred while placing the bid.';

            if (isset($e->errorInfo[2]) && preg_match('/ERROR:\s*(.*?)(?:\n|$)/', $e->errorInfo[2], $matches)) {
                $cleanMessage = $matches[1];
            }

            return back()->withInput()->withErrors(['amount' => $cleanMessage]);
        }
    }
}
