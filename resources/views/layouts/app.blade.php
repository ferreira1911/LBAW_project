<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', config('app.name', 'Laravel'))</title>

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/milligram.css') }}">
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        @stack('styles')

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>
        @stack('scripts')
    </head>
    <body>
        <main>
            <header>
                <h1><a href="{{ route('/') }}">AuctionEase</a></h1>

                <div class="auth-links">
                    @auth
                        <span>{{ Auth::user()->name }}</span>
                        <span>Your credit is {{ Auth::user()->credit }}$</span>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="button button-outline">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="button">Login</a>
                        <a href="{{ route('register') }}" class="button button-outline">Register</a>
                    @endauth
                </div>



                <section id="content">
                    @yield('content')
                </section>
            </header>
        </main>
    </body>
</html>