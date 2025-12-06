<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', config('app.name', 'Laravel'))</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

        <!-- Styles -->
        <!-- <link rel="stylesheet" href="{{ asset('css/milligram.css') }}"> -->
        {{-- <link rel="stylesheet" href="{{ asset('css/app.css') }}"> --}}
        @stack('styles')

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>
        <script src="{{ asset('js/ajax.js') }}" defer></script>
        <script src="https://js.pusher.com/7.0/pusher.min.js" defer></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" defer></script>
        @stack('scripts')
    </head>
    <body class="d-flex flex-column min-vh-100 bg-light">
        <main>
            <nav class="navbar navbar-expand-lg navbar-white bg-white border-bottom sticky-top shadow-sm">
                <div class="container">
                    <a class="navbar-brand fw-bold text-primary d-flex align-items-center" href="{{ url('/') }}">
                        <i class="bi bi-hammer me-2"></i>AuctionEase
                    </a>

                    <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav me-auto">
                            <li class="nav-item">
                                <a class="nav-link {{ Route::is('auctions.index') ? 'active fw-bold' : '' }}" href="{{ route('auctions.index') }}">Auctions</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link {{ Route::is('faq') ? 'active fw-bold' : '' }}" href="{{ route('faq') }}">FAQ</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link {{ Route::is('contact') ? 'active fw-bold' : '' }}" href="{{ route('contact') }}">Contact</a>
                            </li>
                        </ul>

                    
                        <ul class="navbar-nav align-items-center gap-2">
                            @guest
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">Login</a>
                                </li>
                                <li class="nav-item">
                                    <a class="btn btn-primary px-4 rounded-pill" href="{{ route('register') }}">Get Started</a>
                                </li>
                            @else
                                {{-- Create Auction Button --}}
                                @if(!Auth::user()->is_admin)
                                <li class="nav-item me-2">
                                    <a href="{{ route('auctions.create') }}" class="btn btn-primary rounded-pill px-3">
                                        <i class="bi bi-plus-lg"></i> Create
                                    </a>
                                </li>
                            
                                {{-- User Credit (Clickable to go to Wallet) --}}
                                <li class="nav-item me-2">
                                    <a href="{{ route('users.show', Auth::user()) }}" class="btn btn-light border rounded-pill text-success fw-bold" title="Wallet Balance">
                                        €{{ number_format(Auth::user()->credit, 2) }}
                                    </a>
                                </li>
                                @endif
                            
                                {{-- User Dropdown --}}
                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle d-flex align-items-center gap-2" href="#" role="button" data-bs-toggle="dropdown">
                                        @if(Auth::user()->url)
                                            <img src="{{ Auth::user()->getProfileImage() }}" class="rounded-circle object-fit-cover border" width="32" height="32">
                                        @else
                                            <div class="rounded-circle bg-secondary-subtle d-flex align-items-center justify-content-center border" style="width: 32px; height: 32px;">
                                                <i class="bi bi-person-fill text-secondary"></i>
                                            </div>
                                        @endif
                                        <span class="fw-medium">{{ Auth::user()->name }}</span>
                                    </a>
                                
                                    <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2">
                                        <li>
                                            <a class="dropdown-item" href="{{ route('users.show', Auth::user()) }}">
                                                <i class="bi bi-person me-2"></i>Profile
                                            </a>
                                        </li>
                                        @if(Auth::user()->is_admin)
                                            <li>
                                                <a class="dropdown-item" href="{{ route('users.index') }}">
                                                    <i class="bi bi-shield-lock me-2"></i>Administration
                                                </a>
                                            </li>
                                        @endif
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                <i class="bi bi-box-arrow-right me-2"></i>Logout
                                            </a>
                                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                                @csrf
                                            </form>
                                        </li>
                                    </ul>
                                </li>
                            @endguest
                        </ul>
                    </div>
                </div>
            </nav>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <section id="content">
                @yield('content')
            </section>
        </main>
        <footer class="bg-dark border-top py-4 mt-auto">
            <div class="container text-center text-ligth small">
                <p class="mb-0 text-white small">&copy; {{ date('Y') }} AuctionEase. All rights reserved.</p>
            </div>
        </footer>
    <script>
        const baseUrl = "{{ url('/') }}";
    </script>
    </body>
</html>