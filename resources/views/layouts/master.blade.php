<!-- resources/views/layouts/master.blade.php -->
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        html, body {
            height: 100%;
            margin: 0;
        }
        body {
            display: flex;
            flex-direction: column;
        }
        main {
            flex: 1;
        }
        footer {
            flex-shrink: 0;
        }
        .nav-link.active {
            font-weight: bold;
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="bg-primary text-white py-3">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h4 mb-0">My Blog</h1>
                <nav>
                    <ul class="nav">
                        <li class="nav-item"><a href="/" class="nav-link text-white active">Home</a></li>
                        @if (Route::has('login'))
                            @auth
                                <li class="nav-item"><a href="{{ url('/dashboard') }}" class="nav-link text-white">Dashboard</a></li>
                            @else
                                <li class="nav-item"><a href="{{ route('login') }}" class="nav-link text-white">Log in</a></li>
                                @if (Route::has('register'))
                                    <li class="nav-item"><a href="{{ route('register') }}" class="nav-link text-white">Register</a></li>
                                @endif
                            @endauth
                        @endif
                    </ul>
                </nav>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="py-4">
        <div class="container">
            @yield('content')
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-dark text-white py-3">
        <div class="container text-center">
            <p class="mb-0">&copy; 2025 training</p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>