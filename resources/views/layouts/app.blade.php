<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Appointment System')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <style>
        body { background: #f5f6fa; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; }
        .sidebar {
            min-width: 230px;
            max-width: 230px;
            min-height: 100vh;
            background: #1e293b;
            padding: 1.25rem;
        }
        .sidebar .brand {
            font-size: 1.15rem;
            font-weight: 600;
            color: #fff;
            padding-bottom: .75rem;
            margin-bottom: .75rem;
            border-bottom: 1px solid rgba(255,255,255,.1);
        }
        .sidebar nav a {
            display: block;
            padding: 8px 12px;
            margin-bottom: 2px;
            color: rgba(255,255,255,.7);
            text-decoration: none;
            border-radius: 6px;
            font-size: .9rem;
            transition: background .15s, color .15s;
        }
        .sidebar nav a:hover { background: rgba(255,255,255,.08); color: #fff; }
        .sidebar nav a.active { background: rgba(255,255,255,.12); color: #fff; font-weight: 500; }
        .sidebar .user-info {
            margin-top: auto;
            padding-top: .75rem;
            border-top: 1px solid rgba(255,255,255,.1);
            font-size: .82rem;
            color: rgba(255,255,255,.5);
        }
        .sidebar .user-info span { color: rgba(255,255,255,.8); }
        .main-content { padding: 2rem; flex: 1; min-width: 0; }
        .page-title { font-size: 1.35rem; font-weight: 600; margin-bottom: 1.25rem; color: #1e293b; }
    </style>
    @stack('styles')
</head>
<body>
    <div class="d-flex">
        @include('partials.sidebar')
        <main class="main-content">
            @yield('content')
        </main>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        @if(session('success'))
            Swal.fire({ icon: 'success', title: 'Done', text: @json(session('success')), timer: 2500, showConfirmButton: false });
        @endif
        @if(session('error'))
            Swal.fire({ icon: 'error', title: 'Oops', text: @json(session('error')) });
        @endif
    </script>
    @stack('scripts')
</body>
</html>
