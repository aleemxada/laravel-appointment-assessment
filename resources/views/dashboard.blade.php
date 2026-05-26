@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

    <h2 class="mb-4">Dashboard</h2>

    <div class="card">
        <div class="card-header">
            <strong>This Week's Appointments by Doctor</strong>
            <small class="text-muted ms-2">— raw query builder</small>
        </div>
        <div class="card-body p-0">
            @if($weeklyReport->isEmpty())
                <div class="p-3">
                    <x-alert type="info">No appointments this week.</x-alert>
                </div>
            @else
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Doctor</th>
                            <th class="text-center">Appointments This Week</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($weeklyReport as $row)
                            <tr>
                                <td>{{ $row->doctor_name }}</td>
                                <td class="text-center">
                                    <span class="badge bg-primary">{{ $row->total }}</span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>

@endsection