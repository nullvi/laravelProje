<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class AdminRegisterController extends Controller
{
    /**
     * Display the admin registration form.
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function showRegistrationForm()
    {
        // Only allow admin users to access this page
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            return redirect()->route('login')
                ->with('error', 'You do not have permission to access that page.');
        }

        return view('auth.register-admin');
    }

    /**
     * Handle a registration request for an admin user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(Request $request)
    {
        // Only allow admin users to create other admin users
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            return redirect()->route('login')
                ->with('error', 'You do not have permission to perform this action.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'admin',
            'is_approved' => true,
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'Admin user created successfully.');
    }
}
