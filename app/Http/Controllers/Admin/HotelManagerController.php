<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class HotelManagerController extends Controller
{
    /**
     * Display a listing of hotel managers.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $hotelManagers = User::where('role', 'hotel_manager')->latest()->paginate(10);
        return view('admin.hotel-managers.index', compact('hotelManagers'));
    }

    /**
     * Approve a hotel manager.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function approve(Request $request, User $user)
    {
        if ($user->role != 'hotel_manager') {
            return redirect()->route('admin.hotel-managers.index')
                ->with('error', 'Only hotel managers can be approved.');
        }

        $user->update([
            'is_approved' => true
        ]);

        return redirect()->route('admin.hotel-managers.index')
            ->with('success', 'Hotel manager approved successfully.');
    }

    /**
     * Reject a hotel manager.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function reject(Request $request, User $user)
    {
        if ($user->role != 'hotel_manager') {
            return redirect()->route('admin.hotel-managers.index')
                ->with('error', 'Only hotel managers can be rejected.');
        }

        $user->update([
            'is_approved' => false
        ]);

        return redirect()->route('admin.hotel-managers.index')
            ->with('success', 'Hotel manager rejected successfully.');
    }
}
