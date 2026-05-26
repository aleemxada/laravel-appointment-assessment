<aside class="sidebar bg-dark text-white p-3" style="min-width:220px; min-height:100vh">
    <h5 class="mb-4">MedBook</h5>
    <nav>
        <a href="{{ route('dashboard') }}" class="d-block text-white mb-2">Dashboard</a>
        @auth
            @if(auth()->user()->role === 'patient')
                <a href="{{ route('appointments.create') }}" class="d-block text-white mb-2">Book Appointment</a>
            @endif
            <a href="{{ route('appointments.index') }}" class="d-block text-white mb-2">My Appointments</a>
        @endauth
    </nav>
</aside>