@extends('layouts.app')

@section('content')
<h2>Book an Appointment</h2>

<form method="POST" action="{{ route('appointments.store') }}">
    @csrf

    <div class="mb-3">
        <label for="doctor_id" class="form-label">Doctor</label>
        <select name="doctor_id" id="doctor_id" class="form-select @error('doctor_id') is-invalid @enderror">
            <option value="">Select doctor...</option>
            @foreach($doctors as $doctor)
                <option value="{{ $doctor->id }}" {{ old('doctor_id') == $doctor->id ? 'selected' : '' }}>
                    Dr. {{ $doctor->user->name }}
                </option>
            @endforeach
        </select>
        @error('doctor_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="scheduled_at" class="form-label">Date & Time</label>
        <input type="datetime-local" name="scheduled_at" id="scheduled_at"
               value="{{ old('scheduled_at') }}"
               class="form-control @error('scheduled_at') is-invalid @enderror">
        @error('scheduled_at')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="notes" class="form-label">Notes</label>
        <textarea name="notes" id="notes" class="form-control @error('notes') is-invalid @enderror">{{ old('notes') }}</textarea>
        @error('notes')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <button type="submit" class="btn btn-primary">Book Appointment</button>
</form>
@endsection