<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Contracts\AppointmentRepositoryInterface;
use App\Repositories\EloquentAppointmentRepository;
use App\Notifications\Contracts\NotificationStrategy;
use App\Notifications\EmailNotification;

class AppointmentServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            AppointmentRepositoryInterface::class,
            EloquentAppointmentRepository::class
        );

        $this->app->bind(NotificationStrategy::class, EmailNotification::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
