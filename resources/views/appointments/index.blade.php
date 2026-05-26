@extends('layouts.app')

@section('title', 'My Appointments')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="page-title mb-0">My Appointments</h2>
        @if(auth()->user()->role === 'patient')
            <a href="{{ route('appointments.create') }}" class="btn btn-sm btn-primary">+ New Booking</a>
        @endif
    </div>

    @forelse($appointments as $appointment)
        <x-appointment-card :appointment="$appointment">

            {{-- Doctor: confirm pending appointments --}}
            @can('confirm', $appointment)
                <button class="btn btn-sm btn-outline-success btn-confirm me-1"
                        data-form="confirm-form-{{ $appointment->id }}">Confirm</button>
                <form id="confirm-form-{{ $appointment->id }}" method="POST"
                      action="{{ route('appointments.confirm', $appointment) }}" class="d-none">
                    @csrf @method('PATCH')
                </form>
            @endcan

            {{-- Patient: edit pending appointments --}}
            @can('update', $appointment)
                <a href="{{ route('appointments.edit', $appointment) }}" class="btn btn-sm btn-outline-secondary me-1">Edit</a>
            @endcan

            {{-- Both: cancel (patient only pending, doctor any non-cancelled) --}}
            @can('cancel', $appointment)
                <button class="btn btn-sm btn-outline-danger btn-cancel"
                        data-form="cancel-form-{{ $appointment->id }}">Cancel</button>
                <form id="cancel-form-{{ $appointment->id }}" method="POST"
                      action="{{ route('appointments.destroy', $appointment) }}" class="d-none">
                    @csrf @method('DELETE')
                </form>
            @endcan

        </x-appointment-card>
    @empty
        <p class="text-muted">No upcoming appointments.</p>
    @endforelse

    @if($appointments->hasPages())
        <div class="mt-3">{{ $appointments->links() }}</div>
    @endif
@endsection

@push('scripts')
    <script>
        document.querySelectorAll('.btn-confirm').forEach(btn => {
            btn.addEventListener('click', () => {
                Swal.fire({
                    title: 'Confirm this appointment?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#198754',
                    confirmButtonText: 'Yes, confirm',
                    cancelButtonText: 'Not yet'
                }).then(result => {
                    if (result.isConfirmed) {
                        document.getElementById(btn.dataset.form).submit();
                    }
                });
            });
        });

        document.querySelectorAll('.btn-cancel').forEach(btn => {
            btn.addEventListener('click', () => {
                Swal.fire({
                    title: 'Cancel appointment?',
                    text: 'This action cannot be undone.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    confirmButtonText: 'Yes, cancel it',
                    cancelButtonText: 'No, keep it'
                }).then(result => {
                    if (result.isConfirmed) {
                        document.getElementById(btn.dataset.form).submit();
                    }
                });
            });
        });
    </script>
@endpush
