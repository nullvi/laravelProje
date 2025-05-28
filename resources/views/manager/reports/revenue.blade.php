@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Revenue Report</h1>
        <a href="{{ route('manager.dashboard') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to Dashboard
        </a>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-calendar-alt me-1"></i> Select Date Range
        </div>
        <div class="card-body">
            <form action="{{ route('manager.reports.revenue') }}" method="GET" class="row g-3">
                <div class="col-md-4">
                    <label for="start_date" class="form-label">Start Date</label>
                    <input type="date" class="form-control" id="start_date" name="start_date" value="{{ $startDate }}">
                </div>
                <div class="col-md-4">
                    <label for="end_date" class="form-label">End Date</label>
                    <input type="date" class="form-control" id="end_date" name="end_date" value="{{ $endDate }}">
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary">Apply Filter</button>
                </div>
            </form>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-8">
            <div class="card h-100">
                <div class="card-header">
                    <i class="fas fa-chart-line me-1"></i> Revenue by Hotel
                </div>
                <div class="card-body">
                    @if(count($revenueData) > 0)
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Hotel</th>
                                    <th>Revenue</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $totalRevenue = 0; @endphp
                                @foreach($revenueData as $data)
                                <tr>
                                    <td>{{ $data['hotel']->name }}</td>
                                    <td class="text-end">₺{{ number_format($data['total_revenue'], 2) }}</td>
                                </tr>
                                @php $totalRevenue += $data['total_revenue']; @endphp
                                @endforeach
                                <tr class="table-primary">
                                    <th>Total Revenue</th>
                                    <th class="text-end">₺{{ number_format($totalRevenue, 2) }}</th>
                                </tr>
                            </tbody>
                        </table>
                    @else
                        <div class="alert alert-info">
                            <p>No revenue data available for the selected period.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-header">
                    <i class="fas fa-info-circle me-1"></i> Revenue Summary
                </div>
                <div class="card-body">
                    @if(count($revenueData) > 0)
                        @php
                            $totalRevenue = array_sum(array_column($revenueData, 'total_revenue'));
                            $daysDiff = \Carbon\Carbon::parse($startDate)->diffInDays(\Carbon\Carbon::parse($endDate)) + 1;
                            $averageDaily = $daysDiff > 0 ? $totalRevenue / $daysDiff : 0;
                            $monthlyEstimate = $averageDaily * 30;
                            $yearlyEstimate = $averageDaily * 365;
                        @endphp

                        <div class="mb-4 text-center">
                            <div class="display-6">Total Revenue</div>
                            <div class="display-3 fw-bold text-primary">₺{{ number_format($totalRevenue, 2) }}</div>
                            <div class="text-muted">For the period {{ \Carbon\Carbon::parse($startDate)->format('M d, Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('M d, Y') }}</div>
                        </div>

                        <hr>

                        <div class="mt-3">
                            <p><strong>Average Daily Revenue:</strong> ₺{{ number_format($averageDaily, 2) }}</p>
                            <p><strong>Estimated Monthly Revenue:</strong> ₺{{ number_format($monthlyEstimate, 2) }}</p>
                            <p><strong>Estimated Yearly Revenue:</strong> ₺{{ number_format($yearlyEstimate, 2) }}</p>
                            <p><strong>Total Days in Period:</strong> {{ $daysDiff }}</p>
                        </div>
                    @else
                        <div class="alert alert-info">
                            <p>No revenue data available for the selected period.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <i class="fas fa-lightbulb me-1"></i> Revenue Improvement Tips
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title"><i class="fas fa-bed text-primary me-2"></i> Optimize Room Pricing</h5>
                            <p class="card-text">Implement dynamic pricing strategies based on demand, seasonality, and local events to maximize revenue.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title"><i class="fas fa-percentage text-success me-2"></i> Special Promotions</h5>
                            <p class="card-text">Create targeted promotions, packages, and discounts to increase bookings during low-occupancy periods.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title"><i class="fas fa-star text-warning me-2"></i> Enhance Guest Experience</h5>
                            <p class="card-text">Improve facilities, services, and customer service to increase positive reviews and repeat business.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
