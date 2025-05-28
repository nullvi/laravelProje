<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Ana sayfa
     */
    public function index()
    {
        $featuredHotels = Hotel::where('is_active', true)
            ->orderBy('rating', 'desc')
            ->take(6)
            ->get();

        return view('home', compact('featuredHotels'));
    }

    /**
     * Hakkımızda sayfası
     */
    public function about()
    {
        return view('about');
    }

    /**
     * İletişim sayfası
     */
    public function contact()
    {
        return view('contact');
    }

    /**
     * İletişim formu gönderimi
     */
    public function sendContact(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        // Burada e-posta gönderme işlemi yapılacak
        // Mail::to('info@example.com')->send(new ContactFormMail($request->all()));

        return redirect()->back()->with('success', 'Mesajınız başarıyla gönderildi. En kısa sürede sizinle iletişime geçeceğiz.');
    }

    /**
     * Kullanıcı profil sayfası
     */
    public function profile()
    {
        $user = Auth::user();
        $reservations = Reservation::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('customer.profile', compact('user', 'reservations'));
    }

    /**
     * Kullanıcı profil güncelleme
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'current_password' => 'nullable|required_with:password|current_password',
            'password' => 'nullable|min:8|confirmed',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->address = $request->address;

        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        return redirect()->route('profile')->with('success', 'Profil bilgileriniz başarıyla güncellendi.');
    }
}
