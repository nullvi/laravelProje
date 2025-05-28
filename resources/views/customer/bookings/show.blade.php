@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Reservation Details</h1>
        <a href="{{ route('bookings') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to Reservations
        </a>
    </div>

    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif

    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <i class="fas fa-calendar-check"></i> Reservation #{{ is_object($reservation) ? $reservation->id : 'N/A' }}
                        </div>
                        <div>
                            @if(is_object($reservation) && isset($reservation->status))
                                @if($reservation->status == 'confirmed')
                                    <span class="badge bg-success">Confirmed</span>
                                @elseif($reservation->status == 'pending')
                                    <span class="badge bg-warning">Pending</span>
                                @elseif($reservation->status == 'checked_in')
                                    <span class="badge bg-info">Checked In</span>
                                @elseif($reservation->status == 'completed')
                                    <span class="badge bg-secondary">Completed</span>
                                @elseif($reservation->status == 'cancelled')
                                    <span class="badge bg-danger">Cancelled</span>
                                @endif
                            @else
                                <span class="badge bg-secondary">Unknown</span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5>Stay Details</h5>
                            <p><strong>Check-in:</strong> {{ isset($reservation->check_in_date) ? $reservation->check_in_date->format('l, M d, Y') : 'Not set' }}</p>
                            <p><strong>Check-out:</strong> {{ isset($reservation->check_out_date) ? $reservation->check_out_date->format('l, M d, Y') : 'Not set' }}</p>
                            <p><strong>Duration:</strong> {{ isset($reservation->check_in_date) && isset($reservation->check_out_date) ? $reservation->check_in_date->diffInDays($reservation->check_out_date) : '0' }} nights</p>
                            <p><strong>Guests:</strong> {{ $reservation->guests_count ?? 0 }} persons</p>

                            @if(isset($reservation->special_requests) && $reservation->special_requests)
                                <h5 class="mt-3">Special Requests</h5>
                                <p>{{ $reservation->special_requests }}</p>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <h5>Payment Information</h5>
                            <p><strong>Total Price:</strong> ₺{{ number_format($reservation->total_price ?? 0, 2) }}</p>
                            <p><strong>Payment Status:</strong>
                                @if(isset($reservation->payment_status))
                                    @if($reservation->payment_status == 'completed')
                                        <span class="badge bg-success">Paid</span>
                                    @elseif($reservation->payment_status == 'pending')
                                        <span class="badge bg-warning">Pending</span>
                                    @else
                                        <span class="badge bg-danger">{{ ucfirst($reservation->payment_status) }}</span>
                                    @endif
                                @else
                                    <span class="badge bg-secondary">Unknown</span>
                                @endif
                            </p>

                            @if(isset($reservation->payment_status) && $reservation->payment_status == 'completed')
                                <p><strong>Payment Method:</strong> {{ ucfirst(str_replace('_', ' ', $reservation->payment_method ?? 'unknown')) }}</p>
                                <p><strong>Transaction ID:</strong> {{ $reservation->transaction_id ?? 'N/A' }}</p>
                            @endif

                            @if(isset($reservation->status) && isset($reservation->payment_status) && $reservation->status == 'pending' && $reservation->payment_status == 'pending')
                                <a href="{{ route('payment.show', $reservation) }}" class="btn btn-success mt-3">
                                    <i class="fas fa-credit-card"></i> Complete Payment
                                </a>
                            @endif
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-12">
                            <h5>Actions</h5>
                            <div class="d-flex mt-3">
                                @if(isset($reservation->status) && in_array($reservation->status, ['pending', 'confirmed']))
                                    <form action="{{ route('bookings.cancel', $reservation) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel this reservation?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger me-2">
                                            <i class="fas fa-times"></i> Cancel Reservation
                                        </button>
                                    </form>
                                @endif

                                <a href="#" class="btn btn-secondary" onclick="window.print();">
                                    <i class="fas fa-print"></i> Print Details
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-hotel"></i> Hotel & Room Details
                </div>
                <div class="card-body">
                    <h5>{{ isset($reservation->room) && isset($reservation->room->hotel) ? $reservation->room->hotel->name : 'Hotel name not available' }}</h5>
                    <p><i class="fas fa-map-marker-alt"></i> {{ isset($reservation->room) && isset($reservation->room->hotel) ? $reservation->room->hotel->address : 'Address not available' }}</p>
                    <p><i class="fas fa-phone"></i> Contact: +90 123 456 7890</p>

                    <hr>

                    <h5>{{ isset($reservation->room) ? $reservation->room->name : 'Room name not available' }}</h5>
                    <p><strong>Room Type:</strong> {{ isset($reservation->room) ? $reservation->room->name : 'Not available' }}</p>
                    <p><strong>Capacity:</strong> {{ isset($reservation->room) ? $reservation->room->capacity : '0' }} persons</p>
                    <p><strong>Price per Night:</strong> ₺{{ isset($reservation->room) ? number_format($reservation->room->price_per_night, 2) : '0.00' }}</p>

                    <div class="mb-3">
                        @if(isset($reservation->room) && $reservation->room->has_wifi)
                            <span class="badge bg-info me-1"><i class="fas fa-wifi"></i> WiFi</span>
                        @endif

                        @if(isset($reservation->room) && $reservation->room->has_ac)
                            <span class="badge bg-info me-1"><i class="fas fa-snowflake"></i> A/C</span>
                        @endif

                        @if(isset($reservation->room) && $reservation->room->has_tv)
                            <span class="badge bg-info me-1"><i class="fas fa-tv"></i> TV</span>
                        @endif

                        @if(isset($reservation->room) && $reservation->room->has_fridge)
                            <span class="badge bg-info me-1"><i class="fas fa-box"></i> Fridge</span>
                        @endif
                    </div>

                    @if(isset($reservation->room) && $reservation->room->image)
                        <img src="{{ Storage::url($reservation->room->image) }}" alt="{{ $reservation->room->name }}" class="img-fluid rounded">
                    @endif
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <i class="fas fa-info-circle"></i> Reservation Policy
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
@endsection
