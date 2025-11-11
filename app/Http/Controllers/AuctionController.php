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

        return view('pages.auction.show', [
        'auction' => $auction,
        'bids' => $auction->bids()->orderBy('date', 'DESC')->get(),
    ]);
        
    }

    function store(Request $request){
        $this->authorize('create', Auction::class);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'starting_price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:category,id',
        ]);

        $auction = Auction::create([
            'title' => $request->title,
            'description' => $request->description,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'starting_price' => $request->starting_price,
            'current_price' => $request->starting_price, 
            'owner_id' => auth()->id(),
            'category_id' => $request->category_id,
            'is_buy_now_active' => false,
            'is_featured' => false,     
        ]);

        return redirect()->route('auction.show', $auction)
                        ->with('success', 'Auction created successfully!');

    }

    function create(){
        $this->authorize('create', Auction::class);
        $categories = Category::all();
        return view('pages.auction.create', [
        'categories' => $categories,
    ]);
    }


}
