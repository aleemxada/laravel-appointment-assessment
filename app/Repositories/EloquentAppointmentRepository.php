<?php

namespace App\Repositories;

use App\Models\Appointment;
use App\Repositories\Contracts\AppointmentRepositoryInterface;
use Illuminate\Support\Collection;

class EloquentAppointmentRepository implements AppointmentRepositoryInterface
{
    public function findById(int $id): ?Appointment
    {
        return Appointment::find($id);
    }

    public function getByDoctor(int $doctorId): Collection
    {
        return Appointment::where('doctor_id', $doctorId)->get();
    }

    public function getByPatient(int $patientId): Collection
    {
        return Appointment::where('patient_id', $patientId)->get();
    }

    public function create(array $data): Appointment
    {
        return Appointment::create($data);
    }

    public function update(Appointment $appointment, array $data): Appointment
    {
        $appointment->update($data);
        return $appointment->fresh();
    }

    public function delete(Appointment $appointment): void
    {
        $appointment->delete();
    }

    public function hasConflict(int $doctorId, string $scheduledAt, ?int $excludeId = null): bool
    {
        return Appointment::where('doctor_id', $doctorId)
            ->where('scheduled_at', $scheduledAt)
            ->where('status', '!=', 'cancelled')
            ->when($excludeId, fn ($q) => $q->where('id', '!=', $excludeId))
            ->exists();
    }
}
