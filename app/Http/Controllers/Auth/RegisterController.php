<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Kayıt formunu göster
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Otel yöneticisi kayıt formunu göster
     */
    public function showHotelManagerRegistrationForm()
    {
        return view('auth.hotel-manager-register');
    }

    /**
     * Kullanıcı kaydını gerçekleştir
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'password' => ['required', 'confirmed', Password::defaults()],
            'role' => 'required|in:customer',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'is_approved' => true, // Normal kullanıcılar otomatik onaylanır
        ]);

        Auth::login($user);

        return redirect()->route('home')
            ->with('success', 'Hoş geldiniz! Başarıyla kayıt oldunuz.');
    }

    /**
     * Otel yöneticisi kaydını gerçekleştir
     */
    public function registerHotelManager(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'company_name' => 'required|string|max:255',
            'tax_id' => 'required|string|max:20',
            'password' => ['required', 'confirmed', Password::defaults()],
            'role' => 'required|in:hotel_manager',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'is_approved' => false, // Otel yöneticileri için admin onayı gerekir
        ]);

        // Burada otel yöneticisi ile ilgili ek bilgileri de kaydedebiliriz
        // Örneğin şirket adını ve vergi numarası gibi bir profile kaydedebiliriz
        // Şimdilik basit tutuyoruz

        return redirect()->route('login')
            ->with('success', 'Kayıt işleminiz alınmıştır. Hesabınız admin tarafından onaylandıktan sonra giriş yapabilirsiniz.');
    }
}
