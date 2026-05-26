<?php

namespace App\Notifications\Contracts;

use App\Models\Appointment;

interface NotificationStrategy
{
    public function send(Appointment $appointment): void;
}