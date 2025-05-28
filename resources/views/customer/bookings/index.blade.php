@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <h1 class="mb-4">My Reservations</h1>

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

    <div class="card">
        <div class="card-header">
            <i class="fas fa-calendar-alt"></i> All Reservations
        </div>
        <div class="card-body">
            @if(is_array($reservations) ? count($reservations) > 0 : $reservations->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Reservation #</th>
                                <th>Hotel</th>
                                <th>Room</th>
                                <th>Dates</th>
                                <th>Price</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($reservations as $reservation)
                            <tr>
                                <td>{{ $reservation->id }}</td>
                                <td>{{ $reservation->room->hotel->name }}</td>
                                <td>{{ $reservation->room->name }}</td>
                                <td>
                                    {{ $reservation->check_in_date->format('M d, Y') }} -
                                    {{ $reservation->check_out_date->format('M d, Y') }}
                                    <br>
                                    <small class="text-muted">{{ $reservation->check_in_date->diffInDays($reservation->check_out_date) }} nights</small>
                                </td>
                                <td>₺{{ number_format($reservation->total_price, 2) }}</td>
                                <td>
                                    @if($reservation->status == 'confirmed')
                                        <span class="badge bg-success">Confirmed</span>
                                    @elseif($reservation->status == 'pending')
                                        <span class="badge bg-warning">Pending</span>
                                        @if($reservation->payment_status == 'pending')
                                            <span class="badge bg-warning">Payment Pending</span>
                                        @endif
                                    @elseif($reservation->status == 'checked_in')
                                        <span class="badge bg-info">Checked In</span>
                                    @elseif($reservation->status == 'completed')
                                        <span class="badge bg-secondary">Completed</span>
                                    @elseif($reservation->status == 'cancelled')
                                        <span class="badge bg-danger">Cancelled</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('bookings.show', $reservation) }}" class="btn btn-sm btn-primary">
                                            <i class="fas fa-eye"></i> View
                                        </a>

                                        @if(in_array($reservation->status, ['pending', 'confirmed']) &&
                                            ($reservation->status != 'pending' || $reservation->payment_status == 'completed'))
                                            <form action="{{ route('bookings.cancel', $reservation) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel this reservation?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger ms-1">
                                                    <i class="fas fa-times"></i> Cancel
                                                </button>
                                            </form>
                                        @endif

                                        @if($reservation->status == 'pending' && $reservation->payment_status == 'pending')
                                            <a href="{{ route('payment.show', $reservation) }}" class="btn btn-sm btn-success ms-1">
                                                <i class="fas fa-credit-card"></i> Pay
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $reservations->links() }}
                </div>
            @else
                <div class="alert alert-info">
                    <p>You don't have any reservations yet.</p>
                    <a href="{{ route('hotels.index') }}" class="btn btn-primary">
                        <i class="fas fa-search"></i> Browse Hotels
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
