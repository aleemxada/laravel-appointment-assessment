<?php
namespace App\Notifications;

use App\Models\Appointment;

class EmailNotification implements NotificationStrategy
{
    public function send(Appointment $appointment): void
    {
        // TODO: Implement send() method.
    }
}