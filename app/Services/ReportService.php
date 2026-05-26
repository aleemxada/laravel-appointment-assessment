<?php

namespace App\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ReportService
{
    public function getWeeklyAppointmentCountsPerDoctor(): Collection
    {
        return DB::table('appointments')
            ->join('doctors', 'doctors.id', '=', 'appointments.doctor_id')
            ->join('users', 'users.id', '=', 'doctors.user_id')
            ->select(
                'users.name as doctor_name',
                DB::raw('COUNT(*) as total')
            )
            ->whereBetween('appointments.scheduled_at', [
                now()->startOfWeek(),
                now()->endOfWeek(),
            ])
            ->where('appointments.status', '!=', 'cancelled')
            ->groupBy('doctors.id', 'users.name')
            ->orderByDesc('total')
            ->get();
    }
}