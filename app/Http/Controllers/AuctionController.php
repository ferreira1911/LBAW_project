<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Auction;


class AuctionController extends Controller
{

    function index(){
        $auctions = Auction::where('status','Active')
                    ->where('is_featured',true)
                    ->orderBy('end_date','ASC')
                    ->paginate(9);
        $categories = Category::all();
        return view('pages.auction.index', [
            'auctions' => $auctions,
            'categories' => $categories,
        ]);
    }

    function show(Auction $auction) {
        $this->authorize('view', $auction);
        
    }

    function store(Request $request){
        
    }

    function create(){
        $this->authorize('create', Auction::class);
    }

    function search(Request $request){
        $query = $request->input('query');

        // If no query is provided, just redirect home
        if (!$query) {
            return redirect()->route('auctions.index');
        }

        $auctions = Auction::where('status', 'Active') // Only search active auctions
            ->whereRaw("tsvectors @@ plainto_tsquery('english', ?)", [$query]) // The Magic Line
            ->orderByRaw("ts_rank(tsvectors, plainto_tsquery('english', ?)) DESC", [$query]) // Rank by relevance
            ->paginate(12)
            ->withQueryString(); // Keeps the ?query=... in pagination links

        $categories = Category::all();
        // Reuse the same view as the home page to display results
        return view('pages.auction.search', [
            'auctions' => $auctions,
            'searchQuery' => $query, // Pass the query to the view to show it in the UI
            'categories' => $categories,
        ]);
    }


}
