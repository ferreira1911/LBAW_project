<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Auction;
use App\Models\AuctionImage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


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
            'images.*' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $auction->update($validated);

        if ($request->hasFile('images')) {
            $folderPath = 'images/auction';
            foreach ($request->file('images') as $index => $file) {
                $fileName = $file->hashName();
                $file->storeAs($folderPath, $fileName, FileController::$diskName);

                \App\Models\AuctionImage::create([
                    'auction_id' => $auction->id,
                    'path' => $fileName,
                ]);

                if ($index === 0) {
                    $auction->picture = $fileName;
                    $auction->save();
                }
            }
        }


        return redirect()->route('auction.show', $auction)
                        ->with('success', 'Auction updated successfully!');
    }



    public function store(Request $request){
        $this->authorize('create', Auction::class);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'starting_price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'images.*' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048', // multiple images
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

        if ($request->hasFile('images')) {
            $folderPath = 'images/auction';
            foreach ($request->file('images') as $index => $file) {
                $fileName = $file->hashName();
                $file->storeAs($folderPath, $fileName, FileController::$diskName);

                \App\Models\AuctionImage::create([
                    'auction_id' => $auction->id,
                    'path' => $fileName,
                ]);

                if ($index === 0) {
                    $auction->picture = $fileName;
                    $auction->save();
                }
            }
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

    /**
     * Delete a single image from an auction.
     */
    public function destroyImage(Auction $auction, $imageId)
    {
        $this->authorize('update', $auction);

        $image = AuctionImage::find($imageId);
        if (!$image || $image->auction_id !== $auction->id) {
            return redirect()->back()->with('failure', 'Image not found.');
        }

        // Delete file from storage (use same folder used when storing files)
        $folderPath = 'images/auction';
        Storage::disk(FileController::$diskName)->delete($folderPath . '/' . $image->path);

        // If this was the auction's main picture, pick another or null
        if ($auction->picture === $image->path) {
            $next = $auction->images()->where('id', '!=', $image->id)->first();
            $auction->picture = $next ? $next->path : null;
            $auction->save();
        }

        $image->delete();

        return redirect()->back()->with('success', 'Image deleted successfully.');
    }


}
