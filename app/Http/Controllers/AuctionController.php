<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Auction;
use Illuminate\Support\Facades\Auth;


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

        public function edit(Auction $auction){
        $this->authorize('update', $auction);
        return view('pages.auction.edit', ['auction' => $auction]);
    }

    public function update(Request $request, Auction $auction){
        $this->authorize('update', $auction);
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);
        $auction->update($validated);
        
        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('images/auction', 'public');
            $auction->image_path = $path;
        }

        return redirect()->route('auction.show', $auction)->with('success', 'Auction updated!');
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
        
        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('images/auction', 'public');
            $auction->image_path = $path;
        }

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

    function search(Request $request){
        
            $query = $request->input('query');
            $categoryId = $request->input('category');
            $minPrice = $request->input('min_price');
            $maxPrice = $request->input('max_price');
            $sort = $request->input('sort');

            $auctionsQuery = Auction::where('status', 'Active');

            if ($query) {
                $auctionsQuery->whereRaw("tsvectors @@ plainto_tsquery('english', ?)", [$query]);
            }
            if ($categoryId) {
                $auctionsQuery->where('category_id', $categoryId);
            }
            if ($minPrice) {
                $auctionsQuery->where('current_price', '>=', $minPrice);
            }
            if ($maxPrice) {
                $auctionsQuery->where('current_price', '<=', $maxPrice);
            }

            if($sort) {
                switch($sort) {
                    case 'price_asc':
                        $auctionsQuery->orderBy('current_price', 'ASC');
                        break;
                    case 'price_desc':
                        $auctionsQuery->orderBy('current_price', 'DESC');
                        break;
                    case 'ending_soon':
                        $auctionsQuery->orderBy('end_date', 'ASC');
                        break;
                    default:
                        break;
                }
            }


            // 5. Executar consulta
            $auctions = $auctionsQuery->paginate(12)->withQueryString();

            // 6. Obter todas as categorias para a sidebar
            $categories = Category::all();

            // 7. Retornar a view de PESQUISA
            return view('pages.auction.search', [
                'auctions' => $auctions,
                'categories' => $categories,
                'searchQuery' => $query,
            ]);
        
    }

    public function bid(Request $request, Auction $auction){
        if (!$auction->status === 'Active') {
            return back()->withErrors(['message' => 'This auction has already ended.']);
        }

        if ($auction->owner_id === Auth::id()) {
            return back()->withErrors(['message' => 'You cannot bid on your own auction.']);
        }

        if (Auth::user()->credit < $request->amount) {
            return back()->withErrors(['message' => 'You do not have sufficient credit to place this bid.']);
        }

        $highestBidRecord = $auction->bids()->orderBy('amount', 'desc')->first();

        if ($highestBidRecord && $highestBidRecord->user_id === Auth::id()) {
            return back()->withErrors(['message' => 'You are already the highest bidder.']);
        }

        $highestBidAmount = $highestBidRecord ? $highestBidRecord->amount : $auction->starting_price;
        $minIncrement = $auction->starting_price * 0.10; // BR05: 10% of the starting price
        $requiredMinBid = $highestBidAmount + $minIncrement;

        $validationRules = [
            'amount' => [
                'required',
                'numeric',
                'gte:' . $requiredMinBid,
            ],
        ];

        /* if ($auction->is_buy_now_active && !is_null($auction->buy_now_price)) {
            $validationRules['amount'][] = 'lte:' . $auction->buy_now_price;
        } */

        $request->validate($validationRules, [
            'amount.gte' => 'The bid must be at least €' . number_format($requiredMinBid, 2) . '.',
            // 'amount.lte' => 'The bid cannot be higher than the Buy Now price of €' . number_format($auction->buy_now_price, 2) . '.',
        ]);

        $auction->bids()->create([
            'user_id' => Auth::id(),
            'amount' => $request->amount,
            'date' => now(),
        ]);

        $auction->current_price = $request->amount;
        $auction->save();

        return redirect()->route('auction.show', $auction)->with('success', 'Your bid was placed successfully!');
    }


}
