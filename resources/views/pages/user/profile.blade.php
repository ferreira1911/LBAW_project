@extends('layouts.app')

@section('content')
<div class="container">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb mt-3">
      <li class="breadcrumb-item"><a href="{{ route('auctions.index') }}">Home</a></li>
      <li class="breadcrumb-item"><a href="#">Users</a></li>
      <li class="breadcrumb-item active" aria-current="page">{{ $user->name }}</li>
    </ol>
  </nav>

  <h1 class="mt-3">{{ $user->name }}</h1>
  <hr>

  <section class="row">
    <div class="col-md-6 text-center">
      <img src="{{ $user->getProfileImage() }}" alt="{{ $user->name }}'s Profile Picture" class="img-fluid rounded shadow-sm" style="max-height: 400px;">
    </div>
    <div class="col-md-6">
      <h3>User Info</h3>
      <p><b>Name:</b> {{ $user->name }}</p>
      <p><b>Email:</b> {{ $user->email }}</p>
      <p><b>Description:</b> {{ $user->description ?? 'No description provided.' }}</p>

      @if (!empty($canViewBalance) && $canViewBalance)
          <p><b>Credit:</b> {{ $user->credit }} (Held: {{ $user->held_credit }})</p>
      @endif

      <p>
        <b>Rating:</b> 
        {{ isset($user->average_rating) ? number_format($user->average_rating, 1) : 'N/A' }} / 5.0
      </p>

      @if (Auth::id() === $user->id)
      <div class="text-center mt-3">
        <a href="{{ route('user.edit', $user) }}" class="btn btn-primary">Edit Profile</a>
      </div>
      @endif
    </div>
  </section>
</div>
@endsection
