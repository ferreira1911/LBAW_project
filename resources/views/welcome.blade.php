@extends('layouts.app')

@section('title', 'Welcome to AuctionEase')

@section('content')
<div class="container py-5">
    <div class="p-5 mb-4 bg-light rounded-3 border shadow-sm">
        <div class="container-fluid py-5">
            <h1 class="display-5 fw-bold text-primary">Welcome to AuctionEase</h1>
            <p class="col-md-8 fs-4">The best platform to buy and sell unique items securely. Join our community and start bidding on exclusive auctions today.</p>
            <div class="mt-4">
                <a href="{{ url('/auctions') }}" class="btn btn-primary btn-lg px-4 me-md-2">Browse Auctions</a>
                @guest
                    <a href="{{ route('register') }}" class="btn btn-outline-secondary btn-lg px-4">Sign Up</a>
                @endguest
            </div>
        </div>
    </div>

    <div class="row align-items-md-stretch mt-5">
        <div class="col-md-6">
            <div class="h-100 p-5 text-white bg-dark rounded-3">
                <h2>Sell Your Items</h2>
                <p>Have something valuable? Create an auction in minutes and reach thousands of potential buyers.</p>
                @auth
                    <a href="{{ route('auctions.create') }}" class="btn btn-outline-light" type="button">Create Auction</a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline-light" type="button">Login to Sell</a>
                @endauth
            </div>
        </div>
        <div class="col-md-6 mt-3 mt-md-0">
            <div class="h-100 p-5 bg-light border rounded-3">
                <h2>How it Works</h2>
                <p>Our bidding system is real-time and secure. Place your bids, track your favorite items, and win huge deals.</p>
                <a href="{{ route('faq') }}" class="btn btn-outline-secondary">Read FAQ</a>
            </div>
        </div>
    </div>
</div>
@endsection