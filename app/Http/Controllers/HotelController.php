<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\Room;
use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class HotelController extends Controller
{
    /**
     * Display a listing of all hotels.
     */
    public function index(Request $request)
    {
        $query = Hotel::where('is_active', true);

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%");
            });
        }

        // Filter by location
        if ($request->filled('location')) {
            $query->where('location', $request->location);
        }

        $hotels = $query->paginate(9);

        return view('hotels.index', compact('hotels'));
    }

    /**
     * Display the specified hotel.
     */
    public function show(Hotel $hotel)
    {
        if (!$hotel->is_active && !Auth::check()) {
            abort(404);
        }

        $rooms = $hotel->rooms()->where('is_available', true)->get();

        return view('hotels.show', compact('hotel', 'rooms'));
    }

    /**
     * Display a listing of hotels for the hotel manager.
     */
    public function managerHotels()
    {
        $user = Auth::user();
        $hotels = Hotel::where('manager_id', $user->id)->get();

        return view('manager.hotels.index', compact('hotels'));
    }

    /**
     * Display the hotel manager dashboard.
     */
    public function managerDashboard()
    {
        $user = Auth::user();
        $hotels = Hotel::where('manager_id', $user->id)->get();

        $hotelIds = $hotels->pluck('id')->toArray();

        $stats = [
            'hotels_count' => count($hotels),
            'rooms_count' => Room::whereIn('hotel_id', $hotelIds)->count(),
            'active_reservations' => Reservation::whereHas('room', function($query) use ($hotelIds) {
                $query->whereIn('hotel_id', $hotelIds);
            })->whereIn('status', ['confirmed', 'checked_in'])->count(),
            'today_check_ins' => Reservation::whereHas('room', function($query) use ($hotelIds) {
                $query->whereIn('hotel_id', $hotelIds);
            })->whereDate('check_in_date', Carbon::today())->count(),
            'today_check_outs' => Reservation::whereHas('room', function($query) use ($hotelIds) {
                $query->whereIn('hotel_id', $hotelIds);
            })->whereDate('check_out_date', Carbon::today())->count(),
        ];

        $recentReservations = Reservation::whereHas('room', function($query) use ($hotelIds) {
            $query->whereIn('hotel_id', $hotelIds);
        })->with(['user', 'room'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('manager.dashboard', compact('hotels', 'stats', 'recentReservations'));
    }

    /**
     * Show the form for creating a new hotel.
     */
    public function create()
    {
        return view('manager.hotels.create');
    }

    /**
     * Store a newly created hotel in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'address' => 'required|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $hotel = new Hotel($validated);
        $hotel->manager_id = Auth::id();
        $hotel->is_active = true;

        if ($request->hasFile('image')) {
            $hotel->image = $request->file('image')->store('hotels', 'public');
        }

        $hotel->save();

        return redirect()->route('manager.hotels.edit', $hotel)
            ->with('success', 'Hotel created successfully.');
    }

    /**
     * Show the form for editing the specified hotel.
     */
    public function edit(Hotel $hotel)
    {
        $this->authorize('update', $hotel);

        return view('manager.hotels.edit', compact('hotel'));
    }

    /**
     * Update the specified hotel in storage.
     */
    public function update(Request $request, Hotel $hotel)
    {
        $this->authorize('update', $hotel);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'address' => 'required|string',
            'image' => 'nullable|image|max:2048',
            'is_active' => 'nullable|boolean',
        ]);

        if ($request->hasFile('image')) {
            if ($hotel->image) {
                Storage::disk('public')->delete($hotel->image);
            }
            $hotel->image = $request->file('image')->store('hotels', 'public');
        }

        $hotel->name = $validated['name'];
        $hotel->description = $validated['description'];
        $hotel->location = $validated['location'];
        $hotel->address = $validated['address'];
        $hotel->is_active = $request->has('is_active');

        $hotel->save();

        return redirect()->route('manager.hotels.edit', $hotel)
            ->with('success', 'Hotel updated successfully.');
    }

    /**
     * Remove the specified hotel from storage.
     */
    public function destroy(Hotel $hotel)
    {
        $this->authorize('delete', $hotel);

        if ($hotel->image) {
            Storage::disk('public')->delete($hotel->image);
        }

        $hotel->delete();

        return redirect()->route('manager.dashboard')
            ->with('success', 'Hotel deleted successfully.');
    }

    /**
     * Generate an occupancy report for the manager's hotels.
     */
    public function occupancyReport()
    {
        $user = Auth::user();
        $hotels = Hotel::where('manager_id', $user->id)->with('rooms')->get();

        $occupancyData = [];

        foreach ($hotels as $hotel) {
            $totalRooms = $hotel->rooms->count();
            $occupiedRooms = 0;

            if ($totalRooms > 0) {
                $occupiedRooms = Reservation::whereIn('room_id', $hotel->rooms->pluck('id'))
                    ->whereIn('status', ['confirmed', 'checked_in'])
                    ->whereDate('check_in_date', '<=', Carbon::today())
                    ->whereDate('check_out_date', '>=', Carbon::today())
                    ->count();

                $occupancyRate = round(($occupiedRooms / $totalRooms) * 100);
            } else {
                $occupancyRate = 0;
            }

            $occupancyData[] = [
                'hotel' => $hotel,
                'total_rooms' => $totalRooms,
                'occupied_rooms' => $occupiedRooms,
                'occupancy_rate' => $occupancyRate
            ];
        }

        return view('manager.reports.occupancy', compact('occupancyData'));
    }

    /**
     * Generate a revenue report for the manager's hotels.
     */
    public function revenueReport(Request $request)
    {
        $user = Auth::user();
        $hotels = Hotel::where('manager_id', $user->id)->get();

        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->format('Y-m-d'));

        $hotelIds = $hotels->pluck('id')->toArray();

        $revenueData = [];

        foreach ($hotels as $hotel) {
            $totalRevenue = Reservation::whereHas('room', function($query) use ($hotel) {
                $query->where('hotel_id', $hotel->id);
            })
                ->whereIn('status', ['confirmed', 'checked_in', 'completed'])
                ->whereBetween('check_in_date', [$startDate, $endDate])
                ->sum('total_price');

            $revenueData[] = [
                'hotel' => $hotel,
                'total_revenue' => $totalRevenue
            ];
        }

        return view('manager.reports.revenue', compact('revenueData', 'startDate', 'endDate'));
    }
}
