<?php
namespace App\Domain\Models;

use App\Domain\Contracts\Schedulable;

class Doctor extends User implements Schedulable
{
    public function __construct(
        int $id,
        string $name,
        string $email,
        private readonly string $licenseNumber,
        private readonly array $workingHours = [],
    ) {
        parent::__construct($id, $name, $email);
    }

    public function getRole(): string { return 'doctor'; }

    public function getLicenseNumber(): string { return $this->licenseNumber; }

    public function getAvailableSlots(): array
    {
        // Returns array of available time slots based on working hours
        // Actual slot logic handled by AppointmentService
        return $this->workingHours;
    }
}