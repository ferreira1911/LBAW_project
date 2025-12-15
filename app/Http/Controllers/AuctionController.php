<?php

namespace App\Http\Controllers;

use App\Events\AuctionCancelled;
use App\Events\AuctionWinner;
use App\Events\AuctionBought;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Auction;
use App\Models\AuctionImage;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;


class AuctionController extends Controller
{

    public function index(){
        $featuredAuctions = Auction::where('status','Active')
                    ->where('is_featured',true)
                    ->where('featured_until', '>', now())
                    ->orderBy('end_date','ASC')
                    ->paginate(9);

        $myActiveBids = collect();
        
        if (Auth::check()) {
            $myActiveBids = Auction::where('status', 'Active')
                ->whereHas('bids', function($query) {
                    $query->where('user_id', Auth::id());
                })
                ->where('owner_id','!=', Auth::user()->id)
                ->orderBy('end_date', 'asc')
                ->get();
        }

        return view('pages.auction.index', [
            'featuredAuctions' => $featuredAuctions,
            'myActiveBids' => $myActiveBids,
        ]);
    }

    public function show(Auction $auction) {
        $this->authorize('view', $auction);

        $highestBid = $auction->bids()
            ->orderBy('amount', 'DESC')
            ->first();
        
        $bids = $auction->bids()
            ->orderBy('amount', 'DESC')
            ->orderBy('date', 'DESC')
            ->paginate(5);

        return view('pages.auction.show', [
            'auction' => $auction,
            'bids' => $bids,
            'highestBid' => $highestBid
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
            'buy_now_price' => 'nullable|numeric|min:0',
        ]);

        // Handle buy_now_price and is_buy_now_active
        if (!empty($validated['buy_now_price']) && $validated['buy_now_price'] > 0) {
            $validated['is_buy_now_active'] = true;
        } else {
            $validated['buy_now_price'] = null;
            $validated['is_buy_now_active'] = false;
        }

        try{
            $auction->update($validated);

        if ($request->hasFile('images')) {
            $folderPath = 'images/auction';
            foreach ($request->file('images') as $index => $file) {
                $fileName = $file->hashName();
                $file->storeAs($folderPath, $fileName, FileController::$diskName);

                AuctionImage::create([
                    'auction_id' => $auction->id,
                    'path' => $fileName,
                ]);

                if ($index === 0) {
                    $auction->picture = $fileName;
                    $auction->save();
                }
            }
        }

        return redirect()->route('auctions.show', $auction)
                        ->with('success', 'Auction updated successfully!');

        }catch(QueryException $e){
            $message = 'An Unexpected error has occured. Please try again later';

            return back()->withInput()->with('failure', $message);
        }
    }



    public function store(Request $request){
        $this->authorize('create', Auction::class);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'starting_price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:category,id',
            'buy_now_price' => 'nullable|numeric|min:0',
            'images.*' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048', // multiple images
            'should_feature' => 'nullable|boolean',
            'address' => 'nullable|string|max:255',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
        ]);

        // If buy_now_price is provided, enable is_buy_now_active
        $isBuyNowActive = $request->filled('buy_now_price') && (float)$request->buy_now_price > 0;

        $auction = Auction::create([
            'title' => $request->title,
            'description' => $request->description,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'starting_price' => $request->starting_price,
            'current_price' => $request->starting_price,
            'owner_id' => auth()->id(),
            'category_id' => $request->category_id,
            'buy_now_price' => $request->buy_now_price,
            'is_buy_now_active' => $isBuyNowActive,
            'is_featured' => false,
            'address' => $request->address,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ]);

        if ($request->hasFile('images')) {
            $folderPath = 'images/auction';
            foreach ($request->file('images') as $index => $file) {
                $fileName = $file->hashName();
                $file->storeAs($folderPath, $fileName, FileController::$diskName);

                AuctionImage::create([
                    'auction_id' => $auction->id,
                    'path' => $fileName,
                ]);

                if ($index === 0) {
                    $auction->picture = $fileName;
                    $auction->save();
                }
            }
        }

        if ($request->boolean('should_feature')) {
             try {
                 $auction->feature($request->user());
             } catch (\Exception $e) {
                 return redirect()->route('auctions.show', $auction)
                     ->with('warning', 'Auction created, but featuring failed: ' . $e->getMessage());
             }
        }


        return redirect()->route('auctions.show', $auction)
                        ->with('success', 'Auction created successfully!');
    }



    public function create(){
        $this->authorize('create', Auction::class);
        $categories = Category::all();
        return view('pages.auction.create', [
        'categories' => $categories,
    ]);
    }

    public function search(Request $request){
        
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

    public function cancel(Auction $auction)
    {
        $this->authorize('cancel', $auction);

        try {
            $auction->status = 'Cancelled';
            $auction->save();

            event(new AuctionCancelled(Auth::user(), $auction));

            return redirect()->route('auctions.show', $auction)
                ->with('success', 'The auction has been successfully cancelled.');

        } catch (\Exception $e) {
            return back()->with('failure', 'An error occurred while cancelling the auction. Remainder that you cannot cancel an auction with active bids.');
        }
    }


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


    public function administration(Request $request) {
        //$this->authorize('viewDashboard', $request->user());

        $query = Auction::with(['owner', 'category'])->withCount('bids');

        if ($request->has('search') && $request->get('search') != '') {
            $query->where('title', 'ilike', '%' . $request->get('search') . '%');
        }

        $auctions = $query->orderBy('id', 'DESC')->paginate(15);
        return view('pages.auction.administration',[
            'auctions' => $auctions,
        ]);
    }

    public function toggleFollow(Auction $auction)
{
    $user = Auth::user();
    
    if ($auction->owner_id === $user->id) {
        return response()->json(['error' => 'Owner cannot follow auction'], 403);
    }

    $user->followedAuctions()->toggle($auction->id);

    // Check the new state
    $isFollowing = $user->followedAuctions()->where('followed_auction', $auction->id)->exists();

    return response()->json([
        'success' => true,
        'following' => $isFollowing,
        'message' => $isFollowing ? 'Followed' : 'Unfollowed'
    ]);
}
    public function buyNow(Auction $auction)
    {
        $this->authorize('view', $auction);

        $buyer = Auth::user();

        // Check if auction is active and buy now is enabled
        if ($auction->status !== 'Active' || !$auction->is_buy_now_active || !$auction->buy_now_price) {
            return redirect()->back()->with('error', 'This auction is not available for buy now.');
        }

        // Check if buyer is the owner
        if ($buyer->id === $auction->owner_id) {
            return redirect()->back()->with('error', 'You cannot buy your own auction.');
        }

        // Check if buyer has enough credit
        if ($buyer->credit < $auction->buy_now_price) {
            return redirect()->back()->with('error', 'Insufficient credit. Please add funds to your wallet.');
        }

        try {
            DB::transaction(function () use ($auction, $buyer) {
                // Create transaction
                $transaction = Transaction::create([
                    'amount' => $auction->buy_now_price,
                    'status' => 'Completed',
                    'type' => 'auction-buy',
                    'auction_id' => $auction->id,
                    'buyer_id' => $buyer->id,
                    'seller_id' => $auction->owner_id,
                ]);

                // Deduct credit from buyer
                $buyer->decrement('credit', $auction->buy_now_price);

                // Add credit to seller
                $auction->owner->increment('credit', $auction->buy_now_price);

                // End the auction
                $auction->status = 'Ended';
                $auction->save();

                event(new AuctionBought($auction->owner,$auction));

            });

            return redirect()->route('auctions.show', $auction)->with('success', 'Item purchased successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('failure', 'An error occurred during the purchase. Please try again.');
        }
    }

    public function feature(Request $request, Auction $auction)
    {
        $this->authorize('feature', $auction);

        try {
            $auction->feature($request->user());

            return redirect()->route('auctions.show', $auction->id)
                ->with('success', 'Auction featured successfully! 100€ were deducted from your account.');

        } catch (\Exception $e) {
            return back()->with('failure', "Failure in making the auction featured");
        }
    }
}
