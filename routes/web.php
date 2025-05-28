<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\AdminRegisterController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\HotelManagerController;
use App\Http\Controllers\Admin\ReportController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Ana Sayfa ve Açık Sayfalar
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/hotels', [HotelController::class, 'index'])->name('hotels.index');
Route::get('/hotels/{hotel}', [HotelController::class, 'show'])->name('hotels.show');
Route::get('/hotels/{hotel}/rooms', [RoomController::class, 'index'])->name('rooms.index');
Route::get('/hotels/{hotel}/rooms/{room}', [RoomController::class, 'show'])->name('rooms.show');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::post('/contact', [HomeController::class, 'sendContact'])->name('contact.send');

// Kimlik Doğrulama
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);
Route::get('/register/hotel-manager', [RegisterController::class, 'showHotelManagerRegistrationForm'])->name('register.hotel-manager');
Route::post('/register/hotel-manager', [RegisterController::class, 'registerHotelManager']);

// Admin kayıt (sadece mevcut adminler için)
Route::get('/register/admin-user', [AdminRegisterController::class, 'showRegistrationForm'])->name('register.admin.form');
Route::post('/register/admin-user', [AdminRegisterController::class, 'register'])->name('register.admin');

// Müşteri Rotaları
Route::middleware(['auth', 'role:customer'])->group(function () {
    Route::get('/profile', [HomeController::class, 'profile'])->name('profile');
    Route::put('/profile', [HomeController::class, 'updateProfile'])->name('profile.update');

    Route::get('/bookings', [ReservationController::class, 'userBookings'])->name('bookings');
    Route::get('/bookings/{reservation}', [ReservationController::class, 'show'])->name('bookings.show');
    Route::delete('/bookings/{reservation}', [ReservationController::class, 'destroy'])->name('bookings.cancel');

    Route::get('/rooms/{room}/book', [ReservationController::class, 'create'])->name('reservations.create');
    Route::post('/rooms/{room}/book', [ReservationController::class, 'store'])->name('reservations.store');

    Route::get('/payment/{reservation}', [ReservationController::class, 'showPayment'])->name('payment.show');
    Route::post('/payment/{reservation}', [ReservationController::class, 'processPayment'])->name('payment.process');
});

// Otel Yöneticisi Rotaları
Route::middleware(['auth', 'role:hotel_manager', 'approved'])->prefix('manager')->name('manager.')->group(function () {
    Route::get('/dashboard', [HotelController::class, 'managerDashboard'])->name('dashboard');

    // Otel yönetimi
    Route::get('/hotels', [HotelController::class, 'managerHotels'])->name('hotels.index');
    Route::resource('hotels', HotelController::class)->except(['index', 'show']);

    // Oda yönetimi for manager - all routes will have manager. prefix
    Route::get('/hotels/{hotel}/rooms', [RoomController::class, 'index'])->name('hotels.rooms.index');
    Route::get('/hotels/{hotel}/rooms/create', [RoomController::class, 'create'])->name('hotels.rooms.create');
    Route::post('/hotels/{hotel}/rooms', [RoomController::class, 'store'])->name('hotels.rooms.store');
    Route::get('/hotels/{hotel}/rooms/{room}/edit', [RoomController::class, 'edit'])->name('hotels.rooms.edit');
    Route::put('/hotels/{hotel}/rooms/{room}', [RoomController::class, 'update'])->name('hotels.rooms.update');
    Route::delete('/hotels/{hotel}/rooms/{room}', [RoomController::class, 'destroy'])->name('hotels.rooms.destroy');

    // Rezervasyon yönetimi
    Route::get('/reservations', [ReservationController::class, 'managerReservations'])->name('reservations.index');
    Route::get('/reservations/{reservation}', [ReservationController::class, 'managerShow'])->name('reservations.show');
    Route::patch('/reservations/{reservation}/status', [ReservationController::class, 'updateStatus'])->name('reservations.status');

    // Raporlar
    Route::get('/reports/occupancy', [HotelController::class, 'occupancyReport'])->name('reports.occupancy');
    Route::get('/reports/revenue', [HotelController::class, 'revenueReport'])->name('reports.revenue');
});

// Admin Rotaları
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // Kullanıcı yönetimi
    Route::get('/users', [AdminController::class, 'users'])->name('users.index');
    Route::get('/users/{user}/edit', [AdminController::class, 'editUser'])->name('users.edit');
    Route::put('/users/{user}', [AdminController::class, 'updateUser'])->name('users.update');
    Route::delete('/users/{user}', [AdminController::class, 'destroyUser'])->name('users.destroy');

    // Otel yöneticisi onayları
    Route::get('/hotel-managers', [HotelManagerController::class, 'index'])->name('hotel-managers.index');
    Route::patch('/hotel-managers/{user}/approve', [HotelManagerController::class, 'approve'])->name('hotel-managers.approve');
    Route::patch('/hotel-managers/{user}/reject', [HotelManagerController::class, 'reject'])->name('hotel-managers.reject');

    // Otel yönetimi
    Route::get('/hotels', [AdminController::class, 'hotels'])->name('hotels.index');
    Route::get('/hotels/{hotel}/edit', [AdminController::class, 'editHotel'])->name('hotels.edit');
    Route::put('/hotels/{hotel}', [AdminController::class, 'updateHotel'])->name('hotels.update');
    Route::delete('/hotels/{hotel}', [AdminController::class, 'destroyHotel'])->name('hotels.destroy');

    // Oda yönetimi
    Route::get('/rooms', [AdminController::class, 'rooms'])->name('rooms.index');

    // Rezervasyon yönetimi
    Route::get('/reservations', [AdminController::class, 'reservations'])->name('reservations.index');
    Route::get('/reservations/{reservation}', [AdminController::class, 'showReservation'])->name('reservations.show');

    // Raporlar
    Route::get('/reports/revenue', [ReportController::class, 'revenue'])->name('reports.revenue');
    Route::get('/reports/occupancy', [ReportController::class, 'occupancy'])->name('reports.occupancy');

    // Sistem ayarları
    Route::get('/settings', [AdminController::class, 'settings'])->name('settings');
    Route::post('/settings', [AdminController::class, 'updateSettings'])->name('settings.update');
});
