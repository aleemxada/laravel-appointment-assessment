<?php
namespace App\Repositories\Contracts;

use App\Models\Appointment;
use Illuminate\Support\Collection;

interface AppointmentRepositoryInterface
{
    public function findById(int $id): ?Appointment;
    public function getByDoctor(int $doctorId): Collection;
    public function getByPatient(int $patientId): Collection;
    public function create(array $data): Appointment;
    public function update(Appointment $appointment, array $data): Appointment;
    public function delete(Appointment $appointment): void;
    public function hasConflict(int $doctorId, string $scheduledAt, ?int $excludeId = null): bool;
}
