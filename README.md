# MedBook — Appointment Booking System

A Laravel 11 web application for managing doctor-patient appointments.
Patients can book, edit, and cancel appointments. Doctors can view,
confirm, and cancel them.

---

## Requirements

- PHP 8.2+
- Composer
- MySQL 5.7+ (or MariaDB 10.3+)
- A web server (MAMP, Valet, `php artisan serve`, etc.)

Node.js is **not** required — Bootstrap 5 and SweetAlert2 are loaded via CDN.

---

## Installation

```bash
# 1. Clone the repository
git clone https://github.com/YOUR_USERNAME/laravel-appointment-assessment.git
cd laravel-appointment-assessment

# 2. Install PHP dependencies
composer install

# 3. Environment setup
cp .env.example .env
php artisan key:generate

# 4. Configure your database in .env
#    DB_CONNECTION=mysql
#    DB_HOST=127.0.0.1
#    DB_PORT=3306
#    DB_DATABASE=appointment_system
#    DB_USERNAME=root
#    DB_PASSWORD=

# 5. Run migrations and seed the database
php artisan migrate --seed

# 6. Start the development server
php artisan serve
```

The application will be available at `http://localhost:8000`.

---

## Seeded Test Accounts

| Role    | Email                    | Password   |
|---------|--------------------------|------------|
| Doctor  | qaziikram@doctor.com     | password   |
| Doctor  | sajid@example.com        | password   |
| Doctor  | farman@example.com       | password   |
| Patient | patient0@example.com     | password   |
| Patient | patient1@example.com     | password   |

The seeder creates 3 doctors (with specializations), 10 patients, and 20 sample appointments.

---

## Project Structure

```
app/
├── Domain/
│   ├── Contracts/
│   │   └── Schedulable.php          # Interface — getAvailableSlots()
│   └── Models/
│       ├── User.php                 # Abstract class — getRole() abstract method
│       ├── Doctor.php               # Extends User, implements Schedulable
│       └── Patient.php              # Extends User
├── Http/
│   ├── Controllers/
│   │   ├── AppointmentController.php
│   │   └── DashboardController.php
│   ├── Middleware/
│   │   └── EnsureUserIsPatient.php  # Custom middleware — restricts booking to patients
│   └── Requests/
│       └── BookAppointmentRequest.php
├── Models/                          # Eloquent models
│   ├── User.php
│   ├── Doctor.php
│   ├── Patient.php
│   ├── Appointment.php
│   └── Specialization.php
├── Notifications/
│   ├── Contracts/
│   │   └── NotificationStrategy.php # Strategy interface
│   ├── EmailNotification.php        # Concrete strategy
│   └── SmsNotification.php          # Concrete strategy
├── Policies/
│   └── AppointmentPolicy.php        # Authorization — cancel, confirm, update
├── Repositories/
│   ├── Contracts/
│   │   └── AppointmentRepositoryInterface.php
│   └── EloquentAppointmentRepository.php
└── Services/
    ├── AppointmentService.php       # Business logic — booking, cancellation, participant summary
    └── ReportService.php            # Raw query builder — weekly report

resources/views/
├── layouts/app.blade.php            # Master layout with @yield and @stack
├── partials/sidebar.blade.php       # Sidebar navigation via @include
├── components/
│   ├── appointment-card.blade.php   # Anonymous Blade component
│   ├── status-badge.blade.php       # Anonymous Blade component
│   └── alert.blade.php              # Anonymous Blade component
├── dashboard.blade.php
└── appointments/
    ├── index.blade.php
    ├── create.blade.php
    ├── edit.blade.php
    └── show.blade.php
```

---

## Task Coverage

### Task 1 — OOP

- Abstract `User` class with `getRole(): string` abstract method
- Concrete subclasses `Doctor` and `Patient` in `app/Domain/Models/`
- `Schedulable` interface with `getAvailableSlots(): array` implemented by `Doctor`
- All state is `private/protected`, exposed via typed getters (`getId()`, `getName()`, `getEmail()`)
- Polymorphic iteration in `AppointmentService::getParticipantSummary()` — mixed collection of domain objects, same method call, different behavior per class

### Task 2 — Design Patterns

- **Repository pattern**: `AppointmentRepositoryInterface` with `EloquentAppointmentRepository`, bound via `AppServiceProvider`
- **Service layer**: `AppointmentService` handles booking with slot conflict detection and cancellation
- **Strategy pattern**: `NotificationStrategy` interface with `EmailNotification` and `SmsNotification` implementations

### Task 3 — Laravel Conventions

- Route model binding on all appointment routes (`{appointment}`)
- `BookAppointmentRequest` Form Request for validation
- `EnsureUserIsPatient` custom middleware restricts booking/editing to patients
- `scopeUpcoming()` Eloquent scope on the `Appointment` model
- `AppointmentPolicy` authorizes cancel, confirm, and update actions

### Task 4 — Blade UI

- Master layout `layouts/app.blade.php` with `@yield('content')` and `@stack('scripts')`
- Anonymous Blade components: `<x-appointment-card>`, `<x-status-badge>`, `<x-alert>`
- `@forelse / @empty` on the appointment list
- `@push / @stack('scripts')` for page-specific JavaScript (SweetAlert confirmations)
- Sidebar extracted to `partials/sidebar.blade.php` via `@include`
- Booking form uses `@csrf`, `old()`, and `@error` for each field

### Task 5 — Database

- Migrations: `users`, `doctors`, `patients`, `appointments`, `specializations`, `doctor_specialization` pivot, `add_role_to_users`
- Eloquent relationships: `hasOne`, `hasMany`, `belongsTo`, `belongsToMany` (pivot)
- Raw query builder in `ReportService::getWeeklyAppointmentCountsPerDoctor()`
- Indexes on `scheduled_at` and composite `(doctor_id, scheduled_at)` for conflict detection
- Seeders: 3 doctors with specializations, 10 patients, 20 appointments

---

## Database Indexes

Indexes on `scheduled_at` enable efficient range queries for upcoming appointments.
The composite index on `(doctor_id, scheduled_at)` optimizes the conflict detection
query — the most frequent operation in the service layer.

---

## Trade-offs

**Domain models decoupled from Eloquent** — `app/Domain/Models/` contains pure PHP
classes with no Laravel dependency. This keeps OOP concepts clean and testable without
a database. In production, these could be unified with Eloquent models via a DataMapper
or value objects.

**Notification sending is stubbed** — `EmailNotification` and `SmsNotification` log via
`Log::info()` instead of sending real messages. The strategy pattern is fully wired;
swapping in a real driver (Mailgun, Twilio) requires only a new class implementing
`NotificationStrategy`.

**No compiled assets** — Bootstrap 5 and SweetAlert2 are loaded via CDN to keep setup
simple and avoid requiring Node.js.

**Working hours are hardcoded** — `getAvailableSlots()` returns a static array. In
production this would query a `doctor_schedules` table and exclude booked slots
dynamically.
