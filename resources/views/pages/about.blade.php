@extends('layouts.app')

@section('title', 'About Us')

@section('content')
<div class="container py-5">
    <div class="text-center mb-5">
        <h1 class="fw-bold">About AuctionEase</h1>
        <p class="lead text-muted mt-2">
            A secure and modern online auction platform
        </p>
    </div>
    <div class="row g-4 mb-5">
        <div class="col-lg-12">
            <div class="card h-100 shadow-sm border-0 p-4">
                <h4 class="fw-bold mb-3">What is AuctionEase?</h4>
                <p class="text-muted mb-0">
                    <strong>AuctionEase</strong> is a web-based auction platform that connects sellers and buyers in a secure, efficient, and transparent environment. Auction owners can create and manage auctions, while bidders can browse, search, and place bids in real time.
                </p>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card h-100 shadow-sm border-0 p-4">
                <h5 class="fw-bold mb-3">
                    <i class="bi bi-lightbulb me-2 text-primary"></i>Our Vision
                </h5>
                <p class="text-muted mb-0">
                    AuctionEase was built to simplify the auction process and make online bidding more accessible to everyone. We aim to remove unnecessary complexity while maintaining high standards of security and usability.
                </p>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card h-100 shadow-sm border-0 p-4">
                <h5 class="fw-bold mb-3">
                    <i class="bi bi-bullseye me-2 text-primary"></i>Our Purpose
                </h5>
                <p class="text-muted mb-0">
                    Traditional auction systems often struggle with limited reach and poor user experience. AuctionEase provides a centralized, easy-to-use platform where sellers and buyers can interact.
                </p>
            </div>
        </div>
    </div>
    <div class="mb-4 text-center">
        <h3 class="fw-bold">Key Features</h3>
        <p class="text-muted">Everything you need for a complete auction experience</p>
    </div>
    <div class="row g-4">
        <div class="col-md-6 col-lg-3">
            <div class="card h-100 shadow-sm border-0 p-3 text-center">
                <i class="bi bi-search fs-1 text-primary mb-2"></i>
                <h6 class="fw-bold">Search & Browse</h6>
                <p class="text-muted small mb-0">
                    Easily find auctions with category and search filters.
                </p>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="card h-100 shadow-sm border-0 p-3 text-center">
                <i class="bi bi-hammer fs-1 text-primary mb-2"></i>
                <h6 class="fw-bold">Real-Time Bidding</h6>
                <p class="text-muted small mb-0">
                    Place bids instantly and monitor your bidding history.
                </p>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="card h-100 shadow-sm border-0 p-3 text-center">
                <i class="bi bi-plus-circle fs-1 text-primary mb-2"></i>
                <h6 class="fw-bold">Create Auctions</h6>
                <p class="text-muted small mb-0">
                    Set prices, durations, images, and manage your listings.
                </p>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="card h-100 shadow-sm border-0 p-3 text-center">
                <i class="bi bi-star fs-1 text-primary mb-2"></i>
                <h6 class="fw-bold">Ratings & Trust</h6>
                <p class="text-muted small mb-0">
                    Feedback systems help build transparency and trust.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection