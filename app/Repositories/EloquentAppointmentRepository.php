<?php
namespace App\Services;

class AppointmentService
{
    public function __construct(
        private readonly AppointmentRepositoryInterface $repository,
        private readonly NotificationStrategy $notifier,
    ) {}

    public function book(array $data, Patient $patient): Appointment
    {
        if ($this->repository->hasConflict($data['doctor_id'], $data['scheduled_at'])) {
            throw new SlotConflictException('This time slot is already booked.');
        }

        $appointment = $this->repository->create([...$data, 'patient_id' => $patient->id]);

        $this->notifier->send($appointment);

        return $appointment;
    }

    public function cancel(Appointment $appointment): void
    {
        $this->repository->update($appointment, ['status' => 'cancelled']);
    }
}