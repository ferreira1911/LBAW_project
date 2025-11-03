<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\PostLike;

class PostController extends Controller
{
    function show(Request $request) {
        return view('partials.post', ['id' => $request->id]);
    }

    function like(Request $request) {
        event(new PostLike($request->id));
    }
}
