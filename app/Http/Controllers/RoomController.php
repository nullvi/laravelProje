<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class RoomController extends Controller
{
    /**
     * Display a listing of rooms for a specific hotel.
     */
    public function index(Hotel $hotel)
    {
        if (Auth::user()->role === 'hotel_manager') {
            $this->authorize('view', $hotel);

            $rooms = $hotel->rooms()->orderBy('created_at', 'desc')->paginate(10);

            return view('manager.hotels.rooms.index', compact('hotel', 'rooms'));
        } else {
            $rooms = $hotel->rooms()->where('is_active', true)->paginate(10);

            return view('hotels.rooms.index', compact('hotel', 'rooms'));
        }
    }

    /**
     * Show the form for creating a new room for a hotel.
     */
    public function create(Hotel $hotel)
    {
        $this->authorize('update', $hotel);

        return view('manager.hotels.rooms.create', compact('hotel'));
    }

    /**
     * Store a newly created room in storage.
     */
    public function store(Request $request, Hotel $hotel)
    {
        $this->authorize('update', $hotel);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'capacity' => 'required|integer|min:1',
            'price_per_night' => 'required|numeric|min:0',
            'image' => 'nullable|image|max:2048',
            'has_wifi' => 'nullable|boolean',
            'has_ac' => 'nullable|boolean',
            'has_tv' => 'nullable|boolean',
            'has_fridge' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
            'room_number' => [
                'required',
                'string',
                'max:50',
                function ($attribute, $value, $fail) use ($hotel) {
                    // Check if room number already exists for this hotel
                    $exists = \App\Models\Room::where('hotel_id', $hotel->id)
                        ->where('room_number', $value)
                        ->exists();

                    if ($exists) {
                        $fail('Oda numarası bu otel için zaten kullanılıyor. Lütfen başka bir oda numarası seçin.');
                    }
                },
            ],
            'type' => 'required|string|max:50',
        ]);

        $room = new Room();
        $room->hotel_id = $hotel->id;
        $room->name = $validated['name'];
        $room->description = $validated['description'];
        $room->capacity = $validated['capacity'];
        $room->price_per_night = $validated['price_per_night'];
        $room->has_wifi = $request->has('has_wifi');
        $room->has_ac = $request->has('has_ac');
        $room->has_tv = $request->has('has_tv');
        $room->has_fridge = $request->has('has_fridge');
        $room->is_active = $request->has('is_active');
        $room->room_number = $validated['room_number'];
        $room->type = $validated['type'];

        if ($request->hasFile('image')) {
            $room->image = $request->file('image')->store('rooms', 'public');
        }

        $room->save();

        return redirect()->route('manager.hotels.rooms.index', $hotel)
            ->with('success', 'Oda başarıyla oluşturuldu.');
    }

    /**
     * Display the specified room.
     */
    public function show(Hotel $hotel, Room $room)
    {
        if (!$room->is_active && !Auth::check()) {
            abort(404);
        }

        return view('hotels.rooms.show', compact('hotel', 'room'));
    }

    /**
     * Show the form for editing the specified room.
     */
    public function edit(Hotel $hotel, Room $room)
    {
        $this->authorize('update', $hotel);

        if ($room->hotel_id !== $hotel->id) {
            abort(404);
        }

        return view('manager.hotels.rooms.edit', compact('hotel', 'room'));
    }

    /**
     * Update the specified room in storage.
     */
    public function update(Request $request, Hotel $hotel, Room $room)
    {
        $this->authorize('update', $hotel);

        if ($room->hotel_id !== $hotel->id) {
            abort(404);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'capacity' => 'required|integer|min:1',
            'price_per_night' => 'required|numeric|min:0',
            'image' => 'nullable|image|max:2048',
            'has_wifi' => 'nullable|boolean',
            'has_ac' => 'nullable|boolean',
            'has_tv' => 'nullable|boolean',
            'has_fridge' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
            'room_number' => [
                'required',
                'string',
                'max:50',
                function ($attribute, $value, $fail) use ($hotel, $room) {
                    // Check if room number already exists for this hotel (excluding current room)
                    $exists = \App\Models\Room::where('hotel_id', $hotel->id)
                        ->where('room_number', $value)
                        ->where('id', '!=', $room->id)
                        ->exists();

                    if ($exists) {
                        $fail('Oda numarası bu otel için zaten kullanılıyor. Lütfen başka bir oda numarası seçin.');
                    }
                },
            ],
            'type' => 'required|string|max:50',
        ]);

        $room->name = $validated['name'];
        $room->description = $validated['description'];
        $room->capacity = $validated['capacity'];
        $room->price_per_night = $validated['price_per_night'];
        $room->has_wifi = $request->has('has_wifi');
        $room->has_ac = $request->has('has_ac');
        $room->has_tv = $request->has('has_tv');
        $room->has_fridge = $request->has('has_fridge');
        $room->is_active = $request->has('is_active');
        $room->room_number = $validated['room_number'];
        $room->type = $validated['type'];

        if ($request->hasFile('image')) {
            if ($room->image) {
                Storage::disk('public')->delete($room->image);
            }
            $room->image = $request->file('image')->store('rooms', 'public');
        }

        $room->save();

        return redirect()->route('manager.hotels.rooms.index', $hotel)
            ->with('success', 'Room updated successfully.');
    }

    /**
     * Remove the specified room from storage.
     */
    public function destroy(Hotel $hotel, Room $room)
    {
        $this->authorize('update', $hotel);

        if ($room->hotel_id !== $hotel->id) {
            abort(404);
        }

        // Check if room has active reservations
        if ($room->reservations()->whereIn('status', ['confirmed', 'pending', 'checked_in'])->count() > 0) {
            return redirect()->route('manager.hotels.rooms.index', $hotel)
                ->with('error', 'Cannot delete a room with active reservations.');
        }

        if ($room->image) {
            Storage::disk('public')->delete($room->image);
        }

        $room->delete();

        return redirect()->route('manager.hotels.rooms.index', $hotel)
            ->with('success', 'Room deleted successfully.');
    }
}
