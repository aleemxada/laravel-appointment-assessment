@extends('layouts.app')

@section('title', 'My Appointments')

@section('content')
    <h2>Appointments</h2>

    @forelse($appointments as $appointment)
        <x-appointment-card :appointment="$appointment">
            @can('cancel', $appointment)
                <form method="POST" action="{{ route('appointments.destroy', $appointment) }}">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-outline-danger">Cancel</button>
                </form>
            @endcan
        </x-appointment-card>
    @empty
        <x-alert type="info">No appointments found.</x-alert>
    @endforelse
@endsection

@push('scripts')
    <script>
        // page-specific JS: confirm before cancel
        document.querySelectorAll('form[action*="appointments"]').forEach(form => {
            form.addEventListener('submit', e => {
                if (!confirm('Cancel this appointment?')) e.preventDefault();
            });
        });
    </script>
@endpush