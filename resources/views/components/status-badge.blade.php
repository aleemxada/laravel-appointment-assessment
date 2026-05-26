@props(['status'])

@php
$colors = ['pending'=>'warning','confirmed'=>'success','cancelled'=>'danger','completed'=>'secondary'];
$color = $colors[$status] ?? 'secondary';
@endphp

<span class="badge bg-{{ $color }}">{{ ucfirst($status) }}</span>