<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Auction;
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

        $validated = $request->validate([
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'description' => ['required', 'string', 'max:1000'],
        ]);

        $validated['user_id'] = Auth::id();
        $validated['auction_id'] = $auction->id;

        try {
            Review::create($validated);

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

        $averageRating = $seller->average_rating ?? 0;

        return view('pages.review.index', [
            'seller' => $seller,
            'reviews' => $reviews,
            'averageRating' => $averageRating,
        ]);
    }
}