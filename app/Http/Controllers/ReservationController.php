<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    /**
     * Display a list of user's bookings.
     *
     * @return \Illuminate\View\View
     */
    public function userBookings()
    {
        $reservations = Auth::user()->reservations()
            ->with(['room.hotel'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('customer.bookings.index', compact('reservations'));
    }

    /**
     * Display the specified reservation.
     *
     * @param Reservation $reservation
     * @return \Illuminate\View\View
     */
    public function show(Reservation $reservation)
    {
        // Ensure the user can only view their own reservations
        if (Auth::user()->role !== 'admin' && Auth::user()->id !== $reservation->user_id) {
            abort(403, 'Unauthorized action.');
        }

        $reservation->load(['room.hotel', 'user']);

        return view('customer.bookings.show', compact('reservation'));
    }

    /**
     * Show the form for creating a new reservation.
     *
     * @param Room $room
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function create(Room $room)
    {
        $room->load('hotel');

        // Check if room is available for booking
        if (!$room->is_available) {
            return redirect()->route('hotels.show', $room->hotel)
                ->with('error', 'This room is not available for booking.');
        }

        // Get any inputs from the form if available
        $checkIn = request('check_in') ? Carbon::parse(request('check_in')) : null;
        $checkOut = request('check_out') ? Carbon::parse(request('check_out')) : null;
        $guests = request('guests') ? (int)request('guests') : 1;

        return view('customer.bookings.create', compact('room', 'checkIn', 'checkOut', 'guests'));
    }

    /**
     * Store a newly created reservation in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, Room $room)
    {
        $validated = $request->validate([
            'check_in_date' => 'required|date|after_or_equal:today',
            'check_out_date' => 'required|date|after:check_in_date',
            'guests_count' => 'required|integer|min:1|max:' . $room->capacity,
            'special_requests' => 'nullable|string|max:500',
        ]);

        $checkIn = Carbon::parse($validated['check_in_date']);
        $checkOut = Carbon::parse($validated['check_out_date']);
        $days = $checkIn->diffInDays($checkOut);

        // Verify room availability for the selected dates
        if (!$room->isAvailableBetween($checkIn, $checkOut)) {
            return back()->withInput()
                ->with('error', 'The room is not available for the selected dates.');
        }

        // Calculate total price
        $totalPrice = $room->price_per_night * $days;

        // Create the reservation
        $reservation = new Reservation([
            'room_id' => $room->id,
            'user_id' => Auth::id(),
            'check_in_date' => $checkIn,
            'check_out_date' => $checkOut,
            'guests_count' => $validated['guests_count'],
            'total_price' => $totalPrice,
            'special_requests' => $validated['special_requests'] ?? null,
            'status' => 'pending',
            'payment_status' => 'pending',
        ]);

        $reservation->save();

        return redirect()->route('payment.show', $reservation)
            ->with('success', 'Reservation created. Please proceed to payment.');
    }

    /**
     * Show the payment page for a reservation.
     *
     * @param  \App\Models\Reservation  $reservation
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function showPayment(Reservation $reservation)
    {
        // Ensure the user can only pay for their own reservations
        if (Auth::id() !== $reservation->user_id) {
            abort(403, 'Unauthorized action.');
        }

        // Ensure reservation is still pending
        if ($reservation->status !== 'pending' || $reservation->payment_status !== 'pending') {
            return redirect()->route('bookings')
                ->with('error', 'This reservation cannot be paid for anymore.');
        }

        $reservation->load(['room.hotel', 'user']);

        return view('customer.bookings.payment', compact('reservation'));
    }

    /**
     * Process the payment for a reservation.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Reservation  $reservation
     * @return \Illuminate\Http\RedirectResponse
     */
    public function processPayment(Request $request, Reservation $reservation)
    {
        // Ensure the user can only pay for their own reservations
        if (Auth::id() !== $reservation->user_id) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'payment_method' => 'required|in:credit_card,paypal,bank_transfer',
            'card_number' => 'required_if:payment_method,credit_card',
            'card_holder' => 'required_if:payment_method,credit_card',
            'card_expiry' => 'required_if:payment_method,credit_card',
            'card_cvv' => 'required_if:payment_method,credit_card',
        ]);

        // In a real application, process payment with a payment gateway
        // For this demo, we'll simulate successful payment

        // Update reservation status
        $reservation->update([
            'status' => 'confirmed',
            'payment_status' => 'completed',
            'payment_method' => $validated['payment_method'],
            'transaction_id' => 'TRANS-' . uniqid(),
        ]);

        return redirect()->route('bookings.show', $reservation)
            ->with('success', 'Payment successful! Your reservation is confirmed.');
    }

    /**
     * Cancel a reservation.
     *
     * @param  \App\Models\Reservation  $reservation
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Reservation $reservation)
    {
        // Ensure the user can only cancel their own reservations
        if (Auth::id() !== $reservation->user_id) {
            abort(403, 'Unauthorized action.');
        }

        // Can only cancel pending or confirmed reservations
        if (!in_array($reservation->status, ['pending', 'confirmed'])) {
            return back()->with('error', 'This reservation cannot be cancelled.');
        }

        // Check cancellation policy (e.g., check if within 24 hours of check-in)
        $checkInDate = Carbon::parse($reservation->check_in_date);
        $now = Carbon::now();

        if ($now->diffInHours($checkInDate) < 24 && $reservation->status === 'confirmed') {
            return back()->with('error', 'Cancellations must be made at least 24 hours before check-in.');
        }

        // Update reservation status
        $reservation->update([
            'status' => 'cancelled',
        ]);

        return redirect()->route('bookings')
            ->with('success', 'Reservation cancelled successfully.');
    }

    /**
     * Display a list of reservations for the hotel manager.
     *
     * @return \Illuminate\View\View
     */
    public function managerReservations()
    {
        $user = Auth::user();
        $hotels = $user->hotels()->pluck('id');

        // Eğer otel yoksa boş koleksiyon döndür
        if ($hotels->isEmpty()) {
            $reservations = collect([]);
            return view('manager.reservations.index', compact('reservations'));
        }

        $reservations = Reservation::whereHas('room', function($query) use ($hotels) {
            $query->whereIn('hotel_id', $hotels);
        })
        ->with(['room.hotel', 'user'])
        ->orderBy('created_at', 'desc')
        ->paginate(10);

        return view('manager.reservations.index', compact('reservations'));
    }

    /**
     * Display the specified reservation for the hotel manager.
     *
     * @param  \App\Models\Reservation  $reservation
     * @return \Illuminate\View\View
     */
    public function managerShow(Reservation $reservation)
    {
        $user = Auth::user();
        $hotels = $user->hotels()->pluck('id');

        if (!$reservation->room->hotel || !$hotels->contains($reservation->room->hotel->id)) {
            abort(403, 'Unauthorized action.');
        }

        $reservation->load(['room.hotel', 'user']);

        return view('manager.reservations.show', compact('reservation'));
    }

    /**
     * Update the status of a reservation (for hotel managers).
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Reservation  $reservation
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateStatus(Request $request, Reservation $reservation)
    {
        $user = Auth::user();
        $hotels = $user->hotels()->pluck('id');

        if (!$reservation->room->hotel || !$hotels->contains($reservation->room->hotel->id)) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'status' => 'required|in:confirmed,checked_in,completed,cancelled',
        ]);

        $reservation->update([
            'status' => $validated['status'],
        ]);

        return redirect()->route('manager.reservations.show', $reservation)
            ->with('success', 'Reservation status updated successfully.');
    }
}
