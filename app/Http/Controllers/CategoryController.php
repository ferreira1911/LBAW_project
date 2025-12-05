<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;


class CategoryController extends Controller
{
    public function create(){
        $this->authorize('create',Category::class);
        $categories = Category::all();
        return view('pages.admin.category-create',[
            'categories' => $categories,
        ]);
    }
    public function store(Request $request){
        $this->authorize('create',Category::class);
        $validated = $request->validate([
            'name' => 'required'
        ]);

        $equal = Category::where('name',$validated['name'])->exists();

        if($equal){
            return redirect()->back()->with('success', 'The Category already exists');
        }

        try {

            $category = ['name'=> $validated['name']];

            Category::create($category);

            return redirect()->back()->with('success', 'The Category was successfully created');

        } catch (QueryException $e) {

            $cleanMessage = 'An error occurred while creating a Category.';

            if (isset($e->errorInfo[2]) && preg_match('/ERROR:\s*(.*?)(?:\n|$)/', $e->errorInfo[2], $matches)) {
                $cleanMessage = $matches[1];
            }

            return back()->withInput()->with('failure',$cleanMessage);
        }
    }
}
