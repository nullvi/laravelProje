@extends('layouts.admin')

@section('admin-content')
<div class="py-4">
    <h1 class="mb-4">Gelir Raporları</h1>

    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Aylık Gelir (Son 12 Ay)</h5>
                </div>
                <div class="card-body">
                    <canvas id="revenueChart" height="300"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Gelire Göre En İyi Oteller</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Otel</th>
                                    <th>Gelir</th>
                                    <th>Rezervasyon Sayısı</th>
                                    <th>Ortalama Gelir</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($hotelRevenue as $hotel)
                                <tr>
                                    <td>{{ $hotel->name }}</td>
                                    <td>{{ number_format($hotel->revenue, 2) }} ₺</td>
                                    <td>{{ $hotel->reservations_count }}</td>
                                    <td>{{ number_format($hotel->revenue / $hotel->reservations_count, 2) }} ₺</td>
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
        // Monthly revenue chart
        const months = @json($monthlyRevenue->pluck('month'));
        const years = @json($monthlyRevenue->pluck('year'));
        const revenue = @json($monthlyRevenue->pluck('revenue'));

        const labels = months.map((month, index) => {
            const monthNames = ['Ocak', 'Şubat', 'Mart', 'Nisan', 'Mayıs', 'Haziran', 'Temmuz', 'Ağustos', 'Eylül', 'Ekim', 'Kasım', 'Aralık'];
            return monthNames[month-1] + ' ' + years[index];
        });

        const ctx = document.getElementById('revenueChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Gelir (₺)',
                    data: revenue,
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return value.toLocaleString() + ' ₺';
                            }
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.dataset.label + ': ' + context.raw.toLocaleString() + ' ₺';
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
