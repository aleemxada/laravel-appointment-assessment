<?php

namespace App\Services;

use App\Domain\Contracts\Schedulable;
use App\Domain\Models\Doctor as DomainDoctor;
use App\Domain\Models\Patient as DomainPatient;
use App\Domain\Models\User as DomainUser;
use App\Models\Appointment;
use App\Repositories\Contracts\AppointmentRepositoryInterface;

class AppointmentService
{
    public function __construct(
        private readonly AppointmentRepositoryInterface $repository,
    ) {}

    public function book(array $data): Appointment
    {
        if ($this->repository->hasConflict($data['doctor_id'], $data['scheduled_at'])) {
            throw new \Exception('This time slot is already booked.');
        }

        return $this->repository->create($data);
    }

    public function cancel(Appointment $appointment): void
    {
        $this->repository->update($appointment, ['status' => 'cancelled']);
    }

    /**
     * Returns a summary of all participants in an appointment.
     * Iterates a mixed User collection polymorphically — each domain
     * object returns its own role via getRole() without any if/else.
     */
    public function getParticipantSummary(Appointment $appointment): array
    {
        $appointment->load(['doctor.user', 'patient.user']);

        // Build a mixed collection of domain objects
        /** @var DomainUser[] $participants */
        $participants = [
            new DomainDoctor(
                id: $appointment->doctor->id,
                name: $appointment->doctor->user->name,
                email: $appointment->doctor->user->email,
                licenseNumber: $appointment->doctor->license_number,
                workingHours: ['09:00', '10:00', '11:00', '14:00', '15:00'],
            ),
            new DomainPatient(
                id: $appointment->patient->id,
                name: $appointment->patient->user->name,
                email: $appointment->patient->user->email,
            ),
        ];

        $summary = [];

        // Polymorphic call — same method, different behavior per class
        // No if/else needed — each object knows its own role
        foreach ($participants as $participant) {
            $summary[] = [
                'name'  => $participant->getName(),
                'email' => $participant->getEmail(),
                'role'  => $participant->getRole(), // polymorphism here

                // Interface check — only Doctor implements Schedulable
                'slots' => $participant instanceof Schedulable
                    ? $participant->getAvailableSlots()
                    : [],
            ];
        }

        return $summary;
    }
}