<?php

namespace App\Providers;

use App\Models\Appointment;
use App\Policies\AppointmentPolicy;
use App\Repositories\Contracts\AppointmentRepositoryInterface;
use App\Repositories\EloquentAppointmentRepository;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(AppointmentRepositoryInterface::class, EloquentAppointmentRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::policy(Appointment::class, AppointmentPolicy::class);
    }
}
