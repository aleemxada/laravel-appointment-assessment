@props(['appointment', 'showActions' => true])

<div class="card border-0 shadow-sm mb-3">
    <div class="card-body d-flex justify-content-between align-items-start">
        <div>
            <h6 class="mb-1">{{ $appointment->doctor->user->name }}</h6>
            <small class="text-muted">{{ $appointment->scheduled_at->format('D, d M Y \a\t h:i A') }}</small>
            <div class="mt-1">
                <x-status-badge :status="$appointment->status" />
            </div>
        </div>
        @if($showActions)
            <div>{{ $slot }}</div>
        @endif
    </div>
</div>
