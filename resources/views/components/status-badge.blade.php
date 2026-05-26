@props(['status'])

@php
$map = [
    'pending'   => 'warning',
    'confirmed' => 'success',
    'cancelled' => 'danger',
    'completed' => 'secondary',
];
$color = $map[$status] ?? 'secondary';
@endphp

<span class="badge bg-{{ $color }}">{{ ucfirst($status) }}</span>
