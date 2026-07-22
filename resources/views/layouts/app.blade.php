<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Mengo Senior School Library – E-Resources Guide')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <style>
        :root { --mengo-green: #1a5c38; --mengo-gold: #d4a017; }
        .navbar-brand span { color: var(--mengo-gold); }
        .bg-mengo { background-color: var(--mengo-green) !important; }
        .text-mengo { color: var(--mengo-green) !important; }
        .btn-mengo { background-color: var(--mengo-green); color: #fff; }
        .btn-mengo:hover { background-color: #14472b; color: #fff; }
        .resource-card:hover { box-shadow: 0 4px 12px rgba(0,0,0,.12); transition: box-shadow .2s; }
    </style>
    @stack('styles')
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg bg-mengo navbar-dark shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ route('welcome') }}">
            📚 Mengo Library &nbsp;<span>E-Resources</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMain">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navMain">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('welcome') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('search') }}">Search</a>
                </li>
                @auth
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.dashboard') }}">Admin Portal</a>
                </li>
                @endauth
            </ul>
            <form class="d-flex me-3" action="{{ route('search') }}" method="GET">
                <input class="form-control form-control-sm me-2" type="search" name="q"
                       placeholder="Search resources…" value="{{ request('q') }}">
                <button class="btn btn-sm btn-outline-light" type="submit">Go</button>
            </form>
            @auth
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="btn btn-sm btn-outline-warning">
                        Logout ({{ auth()->user()->name }})
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="btn btn-sm btn-outline-light">Librarian Login</a>
            @endauth
        </div>
    </div>
</nav>

<main class="container py-4">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @yield('content')
</main>

<footer class="bg-mengo text-white text-center py-3 mt-5">
    <small>&copy; {{ date('Y') }} Mengo Senior School Library &mdash; New Curriculum E-Resources Guide</small>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>