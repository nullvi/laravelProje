@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6">
        <a href="{{ route('manager.reservations.index') }}" class="inline-flex items-center text-indigo-600 hover:text-indigo-900">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Reservations
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
            <p>{{ session('success') }}</p>
        </div>
    @endif

    <div class="flex flex-col md:flex-row gap-6">
        <!-- Main reservation info -->
        <div class="bg-white rounded-lg shadow overflow-hidden md:w-2/3">
            <div class="p-6 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <h1 class="text-2xl font-bold text-gray-800">Reservation #{{ is_object($reservation) ? $reservation->id : 'Unknown' }}</h1>
@php
    $statusValue = (is_object($reservation) && isset($reservation->status)) ? $reservation->status : null;
@endphp
                    <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full
                        @if($statusValue == 'confirmed') bg-green-100 text-green-800
                        @elseif($statusValue == 'pending') bg-yellow-100 text-yellow-800
                        @elseif($statusValue == 'cancelled') bg-red-100 text-red-800
                        @else bg-gray-100 text-gray-800 @endif">
                        {{ $statusValue ? ucfirst($statusValue) : 'Unknown' }}
                    </span>
                </div>
                <p class="text-sm text-gray-500 mt-1">Created on {{ $reservation->created_at->format('M d, Y H:i') }}</p>
            </div>

            <div class="p-6 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Stay Details</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-600">Check-in Date</p>
                        <p class="text-base font-medium">{{ $reservation->check_in_date->format('M d, Y') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Check-out Date</p>
                        <p class="text-base font-medium">{{ $reservation->check_out_date->format('M d, Y') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Number of Nights</p>
                        <p class="text-base font-medium">{{ $reservation->check_in_date->diffInDays($reservation->check_out_date) }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Number of Guests</p>
                        <p class="text-base font-medium">{{ $reservation->guests_count }}</p>
                    </div>
                </div>
            </div>

            <div class="p-6 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Room Details</h2>
                <div class="flex flex-col md:flex-row">
                    <div class="md:w-1/4">
                        <img src="{{ $reservation->room->image }}" alt="{{ $reservation->room->name }}"
                             class="w-full h-auto rounded-lg object-cover">
                    </div>
                    <div class="md:w-3/4 md:pl-6 mt-4 md:mt-0">
                        <h3 class="text-lg font-medium text-gray-900">{{ $reservation->room->name }}</h3>
                        <p class="text-base text-gray-700">{{ $reservation->room->hotel->name }}</p>
                        <div class="mt-2 text-sm text-gray-500">
                            <p>{{ $reservation->room->description }}</p>
                        </div>
                        <div class="mt-4 flex flex-wrap gap-2">
                            @foreach($reservation->room->amenities as $amenity)
                                <span class="px-2 py-1 bg-gray-100 text-gray-700 text-xs rounded-md">{{ $amenity }}</span>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <div class="p-6 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Payment Information</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-600">Payment Status</p>
                        <p class="text-base font-medium">{{ ucfirst($reservation->payment_status) }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Payment Method</p>
                        <p class="text-base font-medium">{{ $reservation->payment_method ? ucfirst(str_replace('_', ' ', $reservation->payment_method)) : 'Not provided' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Price per Night</p>
                        <p class="text-base font-medium">{{ number_format($reservation->room->price_per_night, 2) }} TL</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Total Price</p>
                        <p class="text-base font-medium">{{ number_format($reservation->total_price, 2) }} TL</p>
                    </div>
                </div>
            </div>

            @if($reservation->special_requests)
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Special Requests</h2>
                <p class="text-base text-gray-700">{{ $reservation->special_requests }}</p>
            </div>
            @endif

            <div class="p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Actions</h2>
                <div class="flex flex-wrap gap-3">
                    @if($reservation->status == 'pending')
                    <form action="{{ route('manager.reservations.status', $reservation) }}" method="POST" class="inline">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="confirmed">
                        <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                            Confirm Reservation
                        </button>
                    </form>
                    @endif

                    @if(in_array($reservation->status, ['pending', 'confirmed']))
                    <form action="{{ route('manager.reservations.status', $reservation) }}" method="POST" class="inline">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="cancelled">
                        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                            Cancel Reservation
                        </button>
                    </form>
                    @endif
                </div>
            </div>
        </div>

        <!-- Guest information -->
        <div class="bg-white rounded-lg shadow overflow-hidden md:w-1/3">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Guest Information</h2>
                <div class="space-y-4">
                    <div>
                        <p class="text-sm text-gray-600">Name</p>
                        <p class="text-base font-medium">{{ $reservation->user->name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Email</p>
                        <p class="text-base font-medium">{{ $reservation->user->email }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Phone</p>
                        <p class="text-base font-medium">{{ $reservation->user->phone ?? 'Not provided' }}</p>
                    </div>
                    @if($reservation->user->address)
                    <div>
                        <p class="text-sm text-gray-600">Address</p>
                        <p class="text-base font-medium">{{ $reservation->user->address }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
