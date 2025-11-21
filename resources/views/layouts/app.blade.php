<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', config('app.name', 'Laravel'))</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

        <!-- Styles -->
        <!-- <link rel="stylesheet" href="{{ asset('css/milligram.css') }}"> -->
        {{-- <link rel="stylesheet" href="{{ asset('css/app.css') }}"> --}}
        @stack('styles')

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>
        <script src="{{ asset('js/ajax.js') }}" defer></script>
        <script src="https://js.pusher.com/7.0/pusher.min.js" defer></script>
        @stack('scripts')
    </head>
    <body>
        <main>
            <nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
                <div class="container">
                    <a class="navbar-brand" href="{{ url('/') }}">AuctionEase</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav ms-auto align-items-center">
                            @auth
                                <li class="nav-item">
                                    <a href="{{ route('auction.create') }}" class="btn btn-primary me-2">Create Auction</a>
                                </li>
                                <li class="nav-item me-2">
                                    <span class="navbar-text fw-bold">{{ Auth::user()->name }}</span>
                                </li>
                                <li class="nav-item me-2">
                                    <span class="navbar-text">Credit: {{ Auth::user()->credit }}$</span>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('user.show', Auth::user()) }}" class="nav-link">Profile</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('users.index') }}" class="nav-link">Admin</a>
                                </li>
                                <li class="nav-item">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="btn btn-outline-danger ms-2">Logout</button>
                                    </form>
                                </li>
                            @else
                                <li class="nav-item">
                                    <a href="{{ route('login') }}" class="btn btn-outline-primary me-2">Login</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('register') }}" class="btn btn-primary">Register</a>
                                </li>
                            @endauth
                        </ul>
                    </div>
                </div>
            </nav>

            <section id="content">
                @yield('content')
            </section>
        </main>
        <footer class="bg-dark text-light py-4 mt-auto">
        <div class="container">
            <div class="d-flex flex-wrap justify-content-between align-items-center">
                <div class="col-md-6 mb-3 mb-md-0">
                    <span class="text-muted">&copy; {{ date('Y') }} AuctionEase. All rights reserved.</span>
                </div>
            </div>
        </div>
    </footer>
    <script>
        const baseUrl = "{{ url('/') }}";
    </script>
    </body>
</html>