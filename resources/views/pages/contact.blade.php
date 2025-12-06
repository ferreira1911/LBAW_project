@extends('layouts.app')

@section('title', 'Contact Support')

@section('content')
<div class="container mt-4">
    <h2>Contact Support</h2>
    <p class="mb-4">If you have a question or need help, fill out the form below and we’ll get back to you as soon as possible.</p>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('contact.send') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Your Name</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Your Email</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required>
        </div>

        <div class="mb-3">
            <label for="subject" class="form-label">Subject</label>
            <input type="text" name="subject" id="subject" class="form-control" value="{{ old('subject') }}" required>
        </div>

        <div class="mb-3">
            <label for="message" class="form-label">Message</label>
            <textarea name="message" id="message" rows="5" class="form-control" required>{{ old('message') }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Send Message</button>
    </form>
</div>
@endsection
