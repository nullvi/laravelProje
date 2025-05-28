@extends('layouts.admin')

@section('admin-content')
<div class="py-4">
    <h1 class="mb-4">Doluluk Raporları</h1>

    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Aylık Doluluk Oranı</h5>
                </div>
                <div class="card-body">
                    <canvas id="occupancyChart" height="300"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Doluluk Oranına Göre En İyi Oteller</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Otel</th>
                                    <th>Dolu Oda Sayısı</th>
                                    <th>Toplam Oda Sayısı</th>
                                    <th>Doluluk Oranı</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($hotelOccupancy as $hotel)
                                <tr>
                                    <td>{{ $hotel->name }}</td>
                                    <td>{{ $hotel->rooms_occupied }}</td>
                                    <td>{{ $hotel->total_rooms }}</td>
                                    <td>
                                        <div class="progress">
                                            <div class="progress-bar bg-success" role="progressbar"
                                                style="width: {{ $hotel->occupancy_rate }}%"
                                                aria-valuenow="{{ $hotel->occupancy_rate }}"
                                                aria-valuemin="0"
                                                aria-valuemax="100">
                                                {{ $hotel->occupancy_rate }}%
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Monthly occupancy chart
        const months = @json(collect($monthlyOccupancy)->pluck('month'));
        const occupancyRates = @json(collect($monthlyOccupancy)->pluck('occupancy_rate'));

        const ctx = document.getElementById('occupancyChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: months,
                datasets: [{
                    label: 'Doluluk Oranı (%)',
                    data: occupancyRates,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 2,
                    tension: 0.1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100,
                        ticks: {
                            callback: function(value) {
                                return value + '%';
                            }
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.dataset.label + ': ' + context.raw + '%';
                            }
                        }
                    }
                }
            }
        });
    });
</script>
@endpush
@endsection
