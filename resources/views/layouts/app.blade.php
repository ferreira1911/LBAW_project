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
                <div class="column">
                    <h1><a href="{{ url('/auction') }}">AuctionEase</a></h1>
                </div>

                <div class="column">
                    <div class="auth-links float-right">
                        @auth
                            <span>{{ Auth::user()->name }}</span>
                            <span>Your credit is {{ Auth::user()->credit }}$</span>
                            <a href="{{ route('user.show',Auth::user()) }}">Profile</a>
                            <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                                @csrf
                                <button type="submit" class="button button-danger button-outline">Logout</button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="button">Login</a>
                            <a href="{{ route('register') }}" class="button button-outline">Register</a>
                        @endauth
                    </div>
                </div>
            </header>

            <section id="content">
                @yield('content')
            </section>
        </main>
    </body>
</html>