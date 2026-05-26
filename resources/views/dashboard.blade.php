@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

    <h2 class="page-title">Dashboard</h2>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-bottom">
            <strong>This Week's Appointments by Doctor</strong>
        </div>
        <div class="card-body p-0">
            @if($weeklyReport->isEmpty())
                <div class="p-3">
                    <x-alert type="info">No appointments this week.</x-alert>
                </div>
            @else
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th class="ps-3">Doctor</th>
                            <th class="text-center" style="width:200px">Appointments</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($weeklyReport as $row)
                            <tr>
                                <td class="ps-3">{{ $row->doctor_name }}</td>
                                <td class="text-center">
                                    <span class="badge bg-primary rounded-pill">{{ $row->total }}</span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>

@endsection
