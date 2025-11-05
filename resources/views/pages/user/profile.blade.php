@extends('layouts.app')

@section('content')
  <div class="container">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb mt-3">
        <li class="breadcrumb-item"><a href="{{ route('auctions.index') }}">Home</a></li>
        <li class="breadcrumb-item"><a>Users</a></li>
        <li class="breadcrumb-item active">{{ $user->name }}</li>
      </ol>
    </nav>
    <h1 class="mt-3">{{ $user->name }}</h1>
    <hr>

    @include('flash::message')

    <section class="row">
      <div class="col-md-6 text-center pb-3">
      <div class="col-md-6">
        <h3>User info</h3>
        <p><b>Name:</b> {{ $user->name }}</p>
        <p><b>Email:</b> {{ $user->email }}</p>
        <p><b>Description:</b> {{ $user->description ?? 'No description provided.' }}</p>
        @if ($canViewBalance)
            <p><b>Credit:</b> {{ $user->credit }} (Held: {{ $user->held_credit }})</p>
        @endif
        <p>Rating: {{ number_format($user->average_rating, 1) ?? 'N/A' }} / 5.0</p>
        
        @if (Auth::id() == $user->id)
        <div class="text-center"> 
          <a href="{{ route('user.edit', $user) }}" class="btn btn-primary">Edit profile</a>
        </div>
        @endif
      </div>
    </section> 
  </div> 
@endsection