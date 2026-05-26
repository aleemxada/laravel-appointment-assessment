@extends('layouts.app')

@section('title', 'Appointment Details')

@section('content')
    <h2 class="page-title">Appointment Details</h2>

    <div class="card border-0 shadow-sm mb-3">
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-sm-4 text-muted">Status</div>
                <div class="col-sm-8"><x-status-badge :status="$appointment->status" /></div>
            </div>
            <div class="row mb-3">
                <div class="col-sm-4 text-muted">Date &amp; Time</div>
                <div class="col-sm-8">{{ $appointment->scheduled_at->format('D, d M Y \a\t h:i A') }}</div>
            </div>
            @if($appointment->notes)
                <div class="row mb-3">
                    <div class="col-sm-4 text-muted">Notes</div>
                    <div class="col-sm-8">{{ $appointment->notes }}</div>
                </div>
            @endif
        </div>
    </div>

    <h5 class="mt-4 mb-3">Participants</h5>
    @foreach($participants as $p)
        <div class="card border-0 shadow-sm mb-2">
            <div class="card-body py-2 px-3 d-flex justify-content-between align-items-center">
                <div>
                    <strong>{{ $p['name'] }}</strong>
                    <span class="text-muted ms-2">{{ $p['email'] }}</span>
                </div>
                <span class="badge bg-{{ $p['role'] === 'doctor' ? 'info' : 'secondary' }}">{{ ucfirst($p['role']) }}</span>
            </div>
        </div>
    @endforeach

    <div class="mt-3">
        <a href="{{ route('appointments.index') }}" class="btn btn-light btn-sm">&larr; Back</a>
    </div>
@endsection
