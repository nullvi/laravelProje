<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    /**
     * Display the revenue report page.
     *
     * @return \Illuminate\View\View
     */
    public function revenue()
    {
        // Get monthly revenue for the last 12 months
        $monthlyRevenue = Reservation::where('status', 'confirmed')
            ->where('payment_status', 'completed')
            ->where('created_at', '>=', Carbon::now()->subMonths(12))
            ->select(
                DB::raw('YEAR(created_at) as year'),
                DB::raw('MONTH(created_at) as month'),
                DB::raw('SUM(total_price) as revenue')
            )
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        // Get revenue by hotel
        $hotelRevenue = Reservation::where('status', 'confirmed')
            ->where('payment_status', 'completed')
            ->join('rooms', 'reservations.room_id', '=', 'rooms.id')
            ->join('hotels', 'rooms.hotel_id', '=', 'hotels.id')
            ->select(
                'hotels.id',
                'hotels.name',
                DB::raw('SUM(reservations.total_price) as revenue'),
                DB::raw('COUNT(reservations.id) as reservations_count')
            )
            ->groupBy('hotels.id', 'hotels.name')
            ->orderBy('revenue', 'desc')
            ->take(10)
            ->get();

        return view('admin.reports.revenue', compact('monthlyRevenue', 'hotelRevenue'));
    }

    /**
     * Display the occupancy report page.
     *
     * @return \Illuminate\View\View
     */
    public function occupancy()
    {
        // Get monthly occupancy rate for the last 12 months
        $now = Carbon::now();
        $startOfYear = Carbon::now()->startOfYear();

        // Total room count
        $totalRoomsCount = Room::count();

        // Monthly occupied rooms
        $monthlyOccupancy = [];

        // Calculate occupancy for each month
        for ($month = 1; $month <= 12; $month++) {
            $startDate = Carbon::create($now->year, $month, 1);
            $endDate = $startDate->copy()->endOfMonth();

            // Skip future months
            if ($startDate > $now) {
                continue;
            }

            $daysInMonth = $startDate->daysInMonth;

            // Count reservations that were active during each month
            $occupiedRoomDays = Reservation::where('status', 'confirmed')
                ->where(function($query) use ($startDate, $endDate) {
                    $query->whereBetween('check_in_date', [$startDate, $endDate])
                        ->orWhereBetween('check_out_date', [$startDate, $endDate])
                        ->orWhere(function($q) use ($startDate, $endDate) {
                            $q->where('check_in_date', '<', $startDate)
                                ->where('check_out_date', '>', $endDate);
                        });
                })
                ->count();

            // Calculate occupancy rate
            $totalPossibleRoomDays = $totalRoomsCount * $daysInMonth;
            $occupancyRate = ($totalPossibleRoomDays > 0)
                ? ($occupiedRoomDays / $totalPossibleRoomDays) * 100
                : 0;

            $monthlyOccupancy[] = [
                'month' => $startDate->format('F'),
                'occupancy_rate' => round($occupancyRate, 2)
            ];
        }

        // Get hotels with highest occupancy rates
        $hotelOccupancy = Reservation::where('status', 'confirmed')
            ->where('check_in_date', '>=', Carbon::now()->subMonths(3))
            ->join('rooms', 'reservations.room_id', '=', 'rooms.id')
            ->join('hotels', 'rooms.hotel_id', '=', 'hotels.id')
            ->select(
                'hotels.id',
                'hotels.name',
                DB::raw('COUNT(DISTINCT rooms.id) as rooms_occupied'),
                DB::raw('(SELECT COUNT(*) FROM rooms WHERE rooms.hotel_id = hotels.id) as total_rooms')
            )
            ->groupBy('hotels.id', 'hotels.name')
            ->orderByRaw('rooms_occupied / total_rooms DESC')
            ->take(10)
            ->get()
            ->map(function ($item) {
                $item->occupancy_rate = ($item->total_rooms > 0)
                    ? round(($item->rooms_occupied / $item->total_rooms) * 100, 2)
                    : 0;
                return $item;
            });

        return view('admin.reports.occupancy', compact('monthlyOccupancy', 'hotelOccupancy'));
    }
}
