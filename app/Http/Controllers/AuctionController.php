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


}
