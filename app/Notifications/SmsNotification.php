<?php
namespace App\Notifications;

use App\Models\Appointment;

class SmsNotification implements NotificationStrategy
{
    public function send(Appointment $appointment): void
    {
        // TODO: Implement send() method.
    }
}