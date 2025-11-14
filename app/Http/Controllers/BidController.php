<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Auction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;

class BidController extends Controller
{
    public function store(Request $request, Auction $auction){
        try {

            $auction->bids()->create([
                'user_id' => Auth::id(),
                'amount' => $request->amount,
                'date' => now(),
            ]);

            $auction->current_price = $request->amount;
            $auction->save();

            return redirect()->route('auction.show', $auction)->with('success', 'Your bid was placed successfully!');

        } catch (QueryException $e) {

            $rawErrorMessage = $e->errorInfo[2] ?? 'An error occurred while placing the bid.';
            $cleanMessage = $rawErrorMessage;

            if (preg_match('/ERROR:\s*(.*?)\s*CONTEXT:/s', $rawErrorMessage, $matches)) {
                $cleanMessage = $matches[1];
            }

            return back()->withInput()->withErrors(['message' => trim($cleanMessage)]);
        }
    }
}
