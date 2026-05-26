<aside class="sidebar d-flex flex-column">
    <div class="brand">MedBook</div>
    <nav>
        <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">Dashboard</a>
        @auth
            <a href="{{ route('appointments.index') }}" class="{{ request()->routeIs('appointments.index') ? 'active' : '' }}">My Appointments</a>
            @if(auth()->user()->role === 'patient')
                <a href="{{ route('appointments.create') }}" class="{{ request()->routeIs('appointments.create') ? 'active' : '' }}">Book Appointment</a>
            @endif
        @endauth
    </nav>
    @auth
        <div class="user-info">
            <span>{{ auth()->user()->name }}</span><br>
            {{ ucfirst(auth()->user()->role) }}
            <div class="mt-2">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" style="background:none;border:none;color:rgba(255,255,255,.5);font-size:.82rem;padding:0;cursor:pointer;">Log out</button>
                </form>
            </div>
        </div>
    @endauth
</aside>
