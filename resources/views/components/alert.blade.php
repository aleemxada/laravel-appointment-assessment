@props(['type' => 'info', 'dismissible' => false])

<div class="alert alert-{{ $type }} {{ $dismissible ? 'alert-dismissible fade show' : '' }}">
    {{ $slot }}
    @if($dismissible)
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    @endif
</div>