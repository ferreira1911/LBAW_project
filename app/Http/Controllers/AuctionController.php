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


}
