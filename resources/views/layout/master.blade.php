<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'My App')</title>

    <!-- Main stylesheet -->
    <link rel="stylesheet" href="{{ asset('assets/css/home-page.css') }}">

    <!-- Optional page-specific styles -->
    @stack('styles')

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('assets/images/logo-apk-simple.png') }}">

    <!-- Fonts & Bootstrap -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
    <!-- Navbar (shared) -->
    <header>
        <nav>
            <img src="{{ asset('resource/Logo B-Vote.png') }}" alt="B-Vote logo" id="bvote_logo">

            <div class="nav-center" role="navigation" aria-label="Main navigation">
                <a href="{{ url('/') }}">Home</a>
                <a href="{{ url('/organization') }}">Organization</a>
            </div>

            {{-- Tampilkan sesuai status autentikasi --}}
            @auth
                <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" class="login">Log Out</button>
                </form>
            @endauth

            @guest
                <a href="{{ route('login') }}" class="login">Log In</a>
            @endguest
        </nav>
    </header>

    <!-- Page content -->
    @yield('content')

    <!-- Footer-level script stacks -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
            integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
            crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
            integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
            crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
            integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
            crossorigin="anonymous"></script>

    @stack('scripts')
</body>
</html>
