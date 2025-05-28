<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Hotel;
use App\Models\Room;
use App\Models\Reservation;

class AdminController extends Controller
{
    /**
     * Display the admin dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function dashboard()
    {
        $usersCount = User::count();
        $hotelsCount = Hotel::count();
        $roomsCount = Room::count();
        $reservationsCount = Reservation::count();

        $latestUsers = User::latest()->take(5)->get();
        $latestReservations = Reservation::with(['user', 'room.hotel'])->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'usersCount',
            'hotelsCount',
            'roomsCount',
            'reservationsCount',
            'latestUsers',
            'latestReservations'
        ));
    }

    /**
     * Display a list of all users.
     *
     * @return \Illuminate\View\View
     */
    public function users()
    {
        $users = User::latest()->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for editing a user.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\View\View
     */
    public function editUser(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateUser(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,hotel_manager,customer',
        ]);

        $user->update($validated);

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified user.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroyUser(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }

    /**
     * Display a list of all hotels.
     *
     * @return \Illuminate\View\View
     */
    public function hotels()
    {
        $hotels = Hotel::with('manager')->latest()->paginate(10);
        return view('admin.hotels.index', compact('hotels'));
    }

    /**
     * Show the form for editing a hotel.
     *
     * @param  \App\Models\Hotel  $hotel
     * @return \Illuminate\View\View
     */
    public function editHotel(Hotel $hotel)
    {
        return view('admin.hotels.edit', compact('hotel'));
    }

    /**
     * Update the specified hotel.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Hotel  $hotel
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateHotel(Request $request, Hotel $hotel)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'city' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|in:active,inactive',
        ]);

        $hotel->update($validated);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('hotels', 'public');
            $hotel->update(['image' => $imagePath]);
        }

        return redirect()->route('admin.hotels.index')->with('success', 'Hotel updated successfully.');
    }

    /**
     * Remove the specified hotel.
     *
     * @param  \App\Models\Hotel  $hotel
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroyHotel(Hotel $hotel)
    {
        $hotel->delete();
        return redirect()->route('admin.hotels.index')->with('success', 'Hotel deleted successfully.');
    }

    /**
     * Display a list of all reservations.
     *
     * @return \Illuminate\View\View
     */
    public function reservations()
    {
        $reservations = Reservation::with(['user', 'room.hotel'])->latest()->paginate(10);
        return view('admin.reservations.index', compact('reservations'));
    }

    /**
     * Display the specified reservation.
     *
     * @param  \App\Models\Reservation  $reservation
     * @return \Illuminate\View\View
     */
    public function showReservation(Reservation $reservation)
    {
        $reservation->load(['user', 'room.hotel']);
        return view('admin.reservations.show', compact('reservation'));
    }

    /**
     * Display a list of all rooms.
     *
     * @return \Illuminate\View\View
     */
    public function rooms()
    {
        $rooms = Room::with(['hotel.manager'])->latest()->paginate(10);
        return view('admin.rooms.index', compact('rooms'));
    }

    /**
     * Display the system settings.
     *
     * @return \Illuminate\View\View
     */
    public function settings()
    {
        return view('admin.settings');
    }

    /**
     * Update the system settings.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateSettings(Request $request)
    {
        // Here you would update the settings values in your database or config files
        // For this example, we'll just redirect back with a success message

        return redirect()->route('admin.settings')->with('success', 'Settings updated successfully.');
    }
}
