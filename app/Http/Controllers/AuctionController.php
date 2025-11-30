<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Auction;
use App\Models\AuctionImage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;
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


        return redirect()->route('auctions.show', $auction)
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
            'category_id' => 'required|exists:category,id',
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


        return redirect()->route('auctions.show', $auction)
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

    public function cancel(Auction $auction)
    {
        $this->authorize('cancel', $auction);

        $auction->status = 'Cancelled';
        $auction->save();

        return redirect()->route('auctions.show', $auction)->with('success', 'The auction has been successfully cancelled.');
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


    public function administration() {
        //$this->authorize('viewDashboard', Auth::user());

        $auctions = Auction::whereIn('status',['Active','Ending'])
                            ->orderBy('end_date','ASC')
                            ->paginate(15);
        return view('pages.auction.administration',[
            'auctions' => $auctions,
        ]);
    }

}
