<?php
interface NotificationStrategy
{
    public function send(Appointment $appointment): void;
}