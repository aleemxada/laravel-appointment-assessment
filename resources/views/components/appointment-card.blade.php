@props(['appointment', 'showActions' => true])

<div class="card mb-3 {{ $appointment->scheduled_at < now() ? 'border-danger' : '' }}">
    <div class="card-body">
        <h6 class="card-title">Dr. {{ $appointment->doctor->user->name }}</h6>
        <p class="card-text">{{ $appointment->scheduled_at->format('D, d M Y H:i') }}</p>
        <x-status-badge :status="$appointment->status" />
        @if($showActions)
            {{ $slot }}
        @endif
    </div>
</div>