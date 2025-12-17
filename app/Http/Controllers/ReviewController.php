<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Auction;
use App\Models\Transaction;
use App\Events\ReviewReceived;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;

class ReviewController extends Controller
{
    public function create(Auction $auction)
    {
        $this->authorize('create', [Review::class, $auction]);

        return view('pages.review.create', [
            'auction' => $auction,
        ]);
    }

    public function store(Request $request, Auction $auction)
    {
        $this->authorize('create', [Review::class, $auction]);
        $user = Auth::user();

        $validated = $request->validate([
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'description' => ['required', 'string', 'max:1000'],
        ]);

        $validated['user_id'] = Auth::id();
        $validated['auction_id'] = $auction->id;

        if ($auction->owner->id === $user->id) {
            return back()->with('failure', 'You cannot review your own auction');
        }

        $alreadyReviewed = Review::where('user_id', $user->id)
            ->where('auction_id', $auction->id)
            ->exists();

        if ($alreadyReviewed) {
            return back()->with('failure', 'You have already reviewed this auction');
        }

        $hasPurchased = Transaction::where('auction_id', $auction->id)
            ->where('buyer_id', $user->id)
            ->exists();

        if (!$hasPurchased) {
            return back()->with('failure', 'Only the verified buyer of this auction can leave a review.');
        }

        try {
            $review = Review::create($validated);

            $recipient = $auction->owner;

            event(new ReviewReceived($recipient,$auction,$review));

            return redirect()->route('auctions.show', $auction)
                ->with('success', 'Review submitted successfully.');
        } catch (QueryException $e) {
            $cleanMessage = 'An error occurred while submitting the review.';

            if (isset($e->errorInfo[2]) && preg_match('/ERROR:\s*(.*?)(?:\n|$)/', $e->errorInfo[2], $matches)) {
                $cleanMessage = $matches[1];
            }

            return back()->withInput()->withErrors(['description' => $cleanMessage]);
        }
    }

    public function index(Request $request)
    {
        $sellerId = $request->input('seller_id');
        
        if (!$sellerId) {
            return redirect()->route('auctions.index')
                ->with('error', 'Seller not specified.');
        }

        $seller = \App\Models\User::findOrFail($sellerId);

        $reviews = Review::whereHas('auction', function($query) use ($sellerId) {
                $query->where('owner_id', $sellerId);
            })
            ->with(['user', 'auction'])
            ->orderBy('created_date', 'desc')
            ->paginate(10);

        $averageRating = $seller->getAverageRating();

        return view('pages.review.index', [
            'seller' => $seller,
            'reviews' => $reviews,
            'averageRating' => $averageRating,
        ]);
    }
}