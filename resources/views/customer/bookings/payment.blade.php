@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Complete Payment</h1>
        <a href="{{ route('bookings') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to Reservations
        </a>
    </div>

    @if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif

    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-credit-card"></i> Payment Details
                </div>
                <div class="card-body">
                    <form action="{{ $reservation ? route('payment.process', $reservation) : route('bookings') }}" method="POST" id="payment-form">
                        @csrf

                        <div class="mb-4">
                            <h5>Select Payment Method</h5>
                            <div class="d-flex flex-wrap gap-3 mt-3">
                                <div class="form-check form-check-inline payment-method-option">
                                    <input class="form-check-input" type="radio" name="payment_method" id="credit_card" value="credit_card" checked>
                                    <label class="form-check-label d-flex align-items-center" for="credit_card">
                                        <span class="me-2">Credit Card</span>
                                        <div>
                                            <i class="fab fa-cc-visa text-primary fa-lg mx-1"></i>
                                            <i class="fab fa-cc-mastercard text-danger fa-lg mx-1"></i>
                                            <i class="fab fa-cc-amex text-info fa-lg mx-1"></i>
                                        </div>
                                    </label>
                                </div>

                                <div class="form-check form-check-inline payment-method-option">
                                    <input class="form-check-input" type="radio" name="payment_method" id="paypal" value="paypal">
                                    <label class="form-check-label d-flex align-items-center" for="paypal">
                                        <span class="me-2">PayPal</span>
                                        <i class="fab fa-paypal text-primary fa-lg"></i>
                                    </label>
                                </div>

                                <div class="form-check form-check-inline payment-method-option">
                                    <input class="form-check-input" type="radio" name="payment_method" id="bank_transfer" value="bank_transfer">
                                    <label class="form-check-label d-flex align-items-center" for="bank_transfer">
                                        <span class="me-2">Bank Transfer</span>
                                        <i class="fas fa-university text-secondary fa-lg"></i>
                                    </label>
                                </div>
                            </div>
                            @error('payment_method')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div id="credit-card-form">
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label for="card_number" class="form-label">Card Number</label>
                                    <input type="text" class="form-control @error('card_number') is-invalid @enderror" id="card_number" name="card_number" placeholder="1234 5678 9012 3456" maxlength="19">
                                    @error('card_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="card_holder" class="form-label">Card Holder Name</label>
                                    <input type="text" class="form-control @error('card_holder') is-invalid @enderror" id="card_holder" name="card_holder" placeholder="John Doe">
                                    @error('card_holder')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-3">
                                    <label for="card_expiry" class="form-label">Expiry Date</label>
                                    <input type="text" class="form-control @error('card_expiry') is-invalid @enderror" id="card_expiry" name="card_expiry" placeholder="MM/YY" maxlength="5">
                                    @error('card_expiry')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-3">
                                    <label for="card_cvv" class="form-label">CVV</label>
                                    <input type="text" class="form-control @error('card_cvv') is-invalid @enderror" id="card_cvv" name="card_cvv" placeholder="123" maxlength="4">
                                    @error('card_cvv')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div id="paypal-form" class="d-none">
                            <div class="alert alert-info">
                                <p>You will be redirected to PayPal to complete your payment after clicking the "Pay Now" button.</p>
                            </div>
                        </div>

                        <div id="bank-transfer-form" class="d-none">
                            <div class="alert alert-info">
                                <h6 class="alert-heading">Bank Account Details</h6>
                                <p><strong>Bank Name:</strong> XYZ Bank</p>
                                <p><strong>Account Name:</strong> Hotel Reservation System</p>
                                <p><strong>Account Number:</strong> 1234567890</p>
                                <p><strong>IBAN:</strong> TR00 0000 0000 0000 0000 0000 00</p>
                                <p><strong>Reference:</strong> BOOKING-{{ is_object($reservation) ? $reservation->id : 'UNKNOWN' }}</p>
                                <p class="mb-0">Please use the reference number when making your bank transfer.</p>
                            </div>
                        </div>

                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-primary btn-lg">Pay ₺{{ number_format($reservation->total_price ?? 0, 2) }}</button>
                        </div>

                        <div class="text-center mt-3">
                            <small class="text-muted">
                                <i class="fas fa-lock me-1"></i> Your payment information is secure and encrypted.
                            </small>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-receipt"></i> Reservation Summary
                </div>
                <div class="card-body">
                    <h5>{{ isset($reservation->room) && isset($reservation->room->hotel) ? $reservation->room->hotel->name : 'Hotel' }}</h5>
                    <p><i class="fas fa-map-marker-alt"></i> {{ isset($reservation->room) && isset($reservation->room->hotel) ? $reservation->room->hotel->address : 'Address not available' }}</p>

                    <hr>

                    <p><strong>Room:</strong> {{ isset($reservation->room) ? $reservation->room->name : 'Room' }}</p>
                    <p><strong>Check-in:</strong> {{ isset($reservation->check_in_date) ? $reservation->check_in_date->format('M d, Y') : 'Date not set' }}</p>
                    <p><strong>Check-out:</strong> {{ isset($reservation->check_out_date) ? $reservation->check_out_date->format('M d, Y') : 'Date not set' }}</p>
                    <p><strong>Guests:</strong> {{ $reservation->guests_count ?? 1 }}</p>
                    <p><strong>Duration:</strong> {{ isset($reservation->check_in_date) && isset($reservation->check_out_date) ? $reservation->check_in_date->diffInDays($reservation->check_out_date) : 0 }} nights</p>

                    <hr>

                    <h6>Price Details</h6>

                    <div class="d-flex justify-content-between mb-2">
                        <span>Room Rate:</span>
                        <span>₺{{ isset($reservation->room) ? number_format($reservation->room->price_per_night ?? 0, 2) : '0.00' }} x {{ isset($reservation->check_in_date) && isset($reservation->check_out_date) ? $reservation->check_in_date->diffInDays($reservation->check_out_date) : 0 }} nights</span>
                    </div>

                    <div class="d-flex justify-content-between fw-bold">
                        <span>Total:</span>
                        <span>₺{{ number_format($reservation->total_price ?? 0, 2) }}</span>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <i class="fas fa-shield-alt"></i> Secure Payment
                </div>
                <div class="card-body">
                    <p>All transactions are secured and encrypted.</p>
                    <p>You can cancel your reservation for free up to 24 hours before check-in. After that, the first night may be charged.</p>
                    <div class="text-center mt-3">
                        <i class="fab fa-cc-visa fa-2x mx-1"></i>
                        <i class="fab fa-cc-mastercard fa-2x mx-1"></i>
                        <i class="fab fa-cc-amex fa-2x mx-1"></i>
                        <i class="fab fa-cc-paypal fa-2x mx-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const creditCardForm = document.getElementById('credit-card-form');
        const paypalForm = document.getElementById('paypal-form');
        const bankForm = document.getElementById('bank-transfer-form');
        const paymentMethods = document.querySelectorAll('input[name="payment_method"]');

        // Format credit card number with spaces
        const cardNumber = document.getElementById('card_number');
        cardNumber.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\s+/g, '').replace(/[^0-9]/gi, '');
            let formattedValue = '';

            for (let i = 0; i < value.length; i++) {
                if (i > 0 && i % 4 === 0) {
                    formattedValue += ' ';
                }
                formattedValue += value[i];
            }

            e.target.value = formattedValue;
        });

        // Format expiry date with slash
        const cardExpiry = document.getElementById('card_expiry');
        cardExpiry.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 2) {
                value = value.substring(0, 2) + '/' + value.substring(2, 4);
            }
            e.target.value = value;
        });

        // Toggle payment forms based on selected method
        paymentMethods.forEach(method => {
            method.addEventListener('change', function() {
                creditCardForm.classList.add('d-none');
                paypalForm.classList.add('d-none');
                bankForm.classList.add('d-none');

                if (this.value === 'credit_card') {
                    creditCardForm.classList.remove('d-none');
                } else if (this.value === 'paypal') {
                    paypalForm.classList.remove('d-none');
                } else if (this.value === 'bank_transfer') {
                    bankForm.classList.remove('d-none');
                }
            });
        });
    });
</script>
@endpush
@endsection
