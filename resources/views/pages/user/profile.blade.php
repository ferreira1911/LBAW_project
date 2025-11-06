@extends('layouts.app')

@section('content')
<div class="container">
  <div style="padding: 2rem 0;">
    <a href="{{ route('auctions.index') }}">Home</a> /
    <a href="#">Users</a> /
    <span>{{ $user->name }}</span>
  </div>

  <div class="row">
    <div class="column column-40">
      <img src="{{ $user->getProfileImage() }}" alt="{{ $user->name }}'s Profile Picture" style="width: 100%; border-radius: 8px;">
    </div>

    <div class="column column-60">
      <h2>User Info</h2>
      <p><strong>Name:</strong> {{ $user->name }}</p>
      <p><strong>Email:</strong> {{ $user->email }}</p>
      <p><strong>Description:</strong> {{ $user->description ?? 'No description provided.' }}</p>

      @if (!empty($canViewBalance) && $canViewBalance)
          <p><strong>Credit:</strong> {{ $user->credit }} (Held: {{ $user->held_credit }})</p>
      @endif

      <p>
        <strong>Rating:</strong> 
        {{ isset($user->average_rating) ? number_format($user->average_rating, 1) : 'N/A' }} / 5.0
      </p>

      @if (Auth::id() === $user->id)
      <div style="margin-top: 2rem;">
        <a href="{{ route('user.edit', $user) }}" class="button">Edit Profile</a>
      </div>
      @endif
    </div>
  </div>
</div>
@endsection
