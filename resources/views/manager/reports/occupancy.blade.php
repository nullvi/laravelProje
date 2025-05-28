@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Occupancy Report</h1>
        <a href="{{ route('manager.dashboard') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to Dashboard
        </a>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-chart-pie me-1"></i> Current Occupancy Rates
        </div>
        <div class="card-body">
            @if(count($occupancyData) > 0)
                <div class="row">
                    @foreach($occupancyData as $data)
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <div class="card-header">
                                {{ $data['hotel']->name }}
                            </div>
                            <div class="card-body">
                                <div class="d-flex justify-content-between mb-3">
                                    <div>
                                        <h5>Occupancy Rate</h5>
                                        <div class="display-4 fw-bold">{{ $data['occupancy_rate'] }}%</div>
                                    </div>
                                    <div class="align-self-center">
                                        @if($data['occupancy_rate'] >= 80)
                                            <div class="text-success display-1">
                                                <i class="fas fa-smile"></i>
                                            </div>
                                        @elseif($data['occupancy_rate'] >= 50)
                                            <div class="text-warning display-1">
                                                <i class="fas fa-meh"></i>
                                            </div>
                                        @else
                                            <div class="text-danger display-1">
                                                <i class="fas fa-frown"></i>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="progress" style="height: 25px;">
                                    <div class="progress-bar {{ $data['occupancy_rate'] >= 80 ? 'bg-success' : ($data['occupancy_rate'] >= 50 ? 'bg-warning' : 'bg-danger') }}"
                                         role="progressbar"
                                         style="width: {{ $data['occupancy_rate'] }}%;"
                                         aria-valuenow="{{ $data['occupancy_rate'] }}"
                                         aria-valuemin="0"
                                         aria-valuemax="100">
                                        {{ $data['occupancy_rate'] }}%
                                    </div>
                                </div>

                                <div class="mt-3">
                                    <p><strong>Total Rooms:</strong> {{ $data['total_rooms'] }}</p>
                                    <p><strong>Occupied Rooms:</strong> {{ $data['occupied_rooms'] }}</p>
                                    <p><strong>Available Rooms:</strong> {{ $data['total_rooms'] - $data['occupied_rooms'] }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="alert alert-info">
                    <p>You don't have any hotels or rooms to display occupancy data for.</p>
                    <a href="{{ route('manager.hotels.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Add Your First Hotel
                    </a>
                </div>
            @endif
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <i class="fas fa-info-circle me-1"></i> Occupancy Statistics Explanation
        </div>
        <div class="card-body">
            <h5>Understanding Occupancy Rates</h5>
            <p>The occupancy rate is calculated by dividing the number of occupied rooms by the total number of available rooms.</p>

            <div class="row mt-3">
                <div class="col-md-4">
                    <div class="card bg-success text-white">
                        <div class="card-body">
                            <h5 class="card-title">High Occupancy (≥80%)</h5>
                            <p class="card-text">Excellent performance. Your hotel is in high demand.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-warning text-dark">
                        <div class="card-body">
                            <h5 class="card-title">Medium Occupancy (50-79%)</h5>
                            <p class="card-text">Good performance but room for improvement.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-danger text-white">
                        <div class="card-body">
                            <h5 class="card-title">Low Occupancy (<50%)</h5>
                            <p class="card-text">Consider promotions or marketing campaigns to increase bookings.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
