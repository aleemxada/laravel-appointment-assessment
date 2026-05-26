<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookAppointmentRequest;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Services\AppointmentService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AppointmentController extends Controller
{
    public function __construct(
        private readonly AppointmentService $appointmentService,
    ) {}

    /**
     * List appointments for the logged-in user.
     * Doctor sees their appointments, patient sees theirs.
     */
    public function index(): View
    {
        $user = auth()->user();

        if ($user->role === 'doctor') {
            $appointments = Appointment::with(['patient.user'])
                ->where('doctor_id', $user->doctor->id)
                ->upcoming()  // scopeUpcoming() — Task 3 requirement
                ->paginate(10);
        } else {
            $appointments = Appointment::with(['doctor.user'])
                ->where('patient_id', $user->patient->id)
                ->upcoming()
                ->paginate(10);
        }

        return view('appointments.index', compact('appointments'));
    }

    /**
     * Show booking form — only patients reach here (middleware handles it).
     */
    public function create(): View
    {
        $doctors = Doctor::with(['user', 'specializations'])->get();

        return view('appointments.create', compact('doctors'));
    }

    /**
     * Store a new appointment.
     * BookAppointmentRequest handles validation automatically — Task 3 requirement.
     * Route is protected by 'patient' middleware.
     */
    public function store(BookAppointmentRequest $request): RedirectResponse
    {
        try {
            $this->appointmentService->book([
                'doctor_id'    => $request->doctor_id,
                'patient_id'   => auth()->user()->patient->id,
                'scheduled_at' => $request->scheduled_at,
                'status'       => 'pending',
                'notes'        => $request->notes,
            ]);

            return redirect()
                ->route('appointments.index')
                ->with('success', 'Appointment booked successfully.');

        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    /**
     * Show single appointment detail with participant summary.
     * Uses route model binding — {appointment} resolves automatically.
     * Uses polymorphic domain objects via AppointmentService — Task 1 requirement.
     */
    public function show(Appointment $appointment): View
    {
        // Authorize — patient sees own, doctor sees own
        $user = auth()->user();

        abort_unless(
            $user->id === $appointment->patient->user_id ||
            $user->id === $appointment->doctor->user_id,
            403
        );

        // Polymorphic participant summary — OOP Task 1 in real flow
        $participants = $this->appointmentService->getParticipantSummary($appointment);

        return view('appointments.show', compact('appointment', 'participants'));
    }

    /**
     * Show edit form.
     */
    public function edit(Appointment $appointment): View
    {
        $this->authorize('update', $appointment);

        $doctors = Doctor::with('user')->get();

        return view('appointments.edit', compact('appointment', 'doctors'));
    }

    /**
     * Update appointment.
     */
    public function update(BookAppointmentRequest $request, Appointment $appointment): RedirectResponse
    {
        $this->authorize('update', $appointment);

        $appointment->update([
            'doctor_id'    => $request->doctor_id,
            'scheduled_at' => $request->scheduled_at,
            'notes'        => $request->notes,
        ]);

        return redirect()
            ->route('appointments.index')
            ->with('success', 'Appointment updated successfully.');
    }

    public function confirm(Appointment $appointment): RedirectResponse
    {
        $this->authorize('confirm', $appointment);

        $appointment->update(['status' => 'confirmed']);

        return redirect()
            ->route('appointments.index')
            ->with('success', 'Appointment confirmed.');
    }

    public function destroy(Appointment $appointment): RedirectResponse
    {
        $this->authorize('cancel', $appointment);  // AppointmentPolicy::cancel()

        $this->appointmentService->cancel($appointment);

        return redirect()
            ->route('appointments.index')
            ->with('success', 'Appointment cancelled.');
    }
}