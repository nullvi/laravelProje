@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Book a Room</h1>
        <a href="{{ route('hotels.show', $room->hotel) }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to Hotel
        </a>
    </div>

    @if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif

    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-calendar-plus"></i> Reservation Details
                </div>
                <div class="card-body">
                    <form action="{{ route('reservations.store', $room) }}" method="POST">
                        @csrf

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="check_in_date" class="form-label">Check-in Date</label>
                                <input type="date" class="form-control @error('check_in_date') is-invalid @enderror" id="check_in_date" name="check_in_date" value="{{ old('check_in_date', date('Y-m-d')) }}" min="{{ date('Y-m-d') }}" required>
                                @error('check_in_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="check_out_date" class="form-label">Check-out Date</label>
                                <input type="date" class="form-control @error('check_out_date') is-invalid @enderror" id="check_out_date" name="check_out_date" value="{{ old('check_out_date', date('Y-m-d', strtotime('+1 day'))) }}" min="{{ date('Y-m-d', strtotime('+1 day')) }}" required>
                                @error('check_out_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="guests_count" class="form-label">Number of Guests</label>
                            <select class="form-select @error('guests_count') is-invalid @enderror" id="guests_count" name="guests_count" required>
                                @for($i = 1; $i <= $room->capacity; $i++)
                                    <option value="{{ $i }}" {{ old('guests_count') == $i ? 'selected' : '' }}>{{ $i }} {{ $i == 1 ? 'Guest' : 'Guests' }}</option>
                                @endfor
                            </select>
                            @error('guests_count')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">This room can accommodate up to {{ $room->capacity }} guests.</div>
                        </div>

                        <div class="mb-3">
                            <label for="special_requests" class="form-label">Special Requests (Optional)</label>
                            <textarea class="form-control @error('special_requests') is-invalid @enderror" id="special_requests" name="special_requests" rows="3">{{ old('special_requests') }}</textarea>
                            @error('special_requests')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Please note that special requests are subject to availability and cannot be guaranteed.</div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">Proceed to Payment</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-hotel"></i> Room Information
                </div>
                <div class="card-body">
                    <h5>{{ $room->hotel->name }}</h5>
                    <p><i class="fas fa-map-marker-alt"></i> {{ $room->hotel->address }}</p>

                    <hr>

                    <h5>{{ $room->name }}</h5>

                    @if($room->image)
                        <img src="{{ Storage::url($room->image) }}" alt="{{ $room->name }}" class="img-fluid rounded mb-3">
                    @endif

                    <p>{{ $room->description }}</p>

                    <div class="mb-3">
                        @if($room->has_wifi)
                            <span class="badge bg-info me-1"><i class="fas fa-wifi"></i> WiFi</span>
                        @endif

                        @if($room->has_ac)
                            <span class="badge bg-info me-1"><i class="fas fa-snowflake"></i> A/C</span>
                        @endif

                        @if($room->has_tv)
                            <span class="badge bg-info me-1"><i class="fas fa-tv"></i> TV</span>
                        @endif

                        @if($room->has_fridge)
                            <span class="badge bg-info me-1"><i class="fas fa-box"></i> Fridge</span>
                        @endif
                    </div>

                    <div class="alert alert-info">
                        <h6 class="alert-heading">Price</h6>
                        <p class="mb-0">₺{{ number_format($room->price_per_night, 2) }} per night</p>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <i class="fas fa-info-circle"></i> Booking Information
                </div>
                <div class="card-body">
                    <p><strong>Check-in Time:</strong> 14:00</p>
                    <p><strong>Check-out Time:</strong> 12:00</p>
                    <p><strong>Cancellation Policy:</strong> Free cancellation up to 24 hours before check-in. After that, the first night may be charged.</p>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const checkInDate = document.getElementById('check_in_date');
        const checkOutDate = document.getElementById('check_out_date');

        checkInDate.addEventListener('change', function() {
            const minCheckOutDate = new Date(checkInDate.value);
            minCheckOutDate.setDate(minCheckOutDate.getDate() + 1);

            const formattedDate = minCheckOutDate.toISOString().split('T')[0];
            checkOutDate.min = formattedDate;

            if (new Date(checkOutDate.value) <= new Date(checkInDate.value)) {
                checkOutDate.value = formattedDate;
            }
        });
    });
</script>
@endpush
@endsection
