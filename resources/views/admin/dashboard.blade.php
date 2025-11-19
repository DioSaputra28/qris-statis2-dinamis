@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Total Transactions -->
        <div class="stats shadow">
            <div class="stat">
                <div class="stat-figure text-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
                <div class="stat-title">Total Transaksi</div>
                <div class="stat-value text-primary">{{ number_format($stats['total_transactions_all']) }}</div>
                <div class="stat-desc">
                    @if($stats['transactions_change'] > 0)
                        ↗︎ {{ $stats['transactions_change'] }}% dari kemarin
                    @elseif($stats['transactions_change'] < 0)
                        ↘︎ {{ abs($stats['transactions_change']) }}% dari kemarin
                    @else
                        Sama dengan kemarin
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Total Revenue -->
        <div class="stats shadow">
            <div class="stat">
                <div class="stat-figure text-secondary">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="stat-title">Total Pendapatan</div>
                <div class="stat-value text-secondary text-lg lg:text-3xl">Rp {{ number_format($stats['total_revenue_all'], 0, ',', '.') }}</div>
                <div class="stat-desc">Bulan ini: Rp {{ number_format($stats['total_revenue_month'], 0, ',', '.') }}</div>
            </div>
        </div>
        
        <!-- Total Clicks -->
        <div class="stats shadow">
            <div class="stat">
                <div class="stat-figure text-accent">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                </div>
                <div class="stat-title">Total Click QRIS</div>
                <div class="stat-value text-accent">{{ number_format($stats['total_clicks']) }}</div>
                <div class="stat-desc">Engagement metric</div>
            </div>
        </div>
        
        <!-- Total API Calls -->
        <div class="stats shadow">
            <div class="stat">
                <div class="stat-figure text-info">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l3 3-3 3m5 0h3M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <div class="stat-title">Total API Calls</div>
                <div class="stat-value text-info">{{ number_format($stats['total_api_calls']) }}</div>
                <div class="stat-desc">API usage monitoring</div>
            </div>
        </div>
    </div>

    <!-- Transaction Chart -->
    <div class="card bg-base-100 shadow">
        <div class="card-body">
            <div class="flex justify-between items-center mb-4">
                <h2 class="card-title">Grafik Transaksi</h2>
                <div class="join">
                    <button class="join-item btn btn-sm btn-active" id="btn-daily">Harian</button>
                    <button class="join-item btn btn-sm" id="btn-monthly">Bulanan</button>
                </div>
            </div>
            <div class="h-80 w-full">
                <canvas id="transactionChart"></canvas>
            </div>
        </div>
    </div>
    
    <!-- Quick Actions & Status -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
        <!-- Quick Actions -->
        <div class="lg:col-span-2">
            <div class="card bg-base-100 shadow">
                <div class="card-body">
                    <h2 class="card-title mb-4">Quick Actions</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <a href="{{ route('transactions.index') }}" class="btn btn-primary btn-lg gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            Buat Transaksi Baru
                        </a>
                        
                        @if($apiKeysCount > 0)
                            <a href="{{ route('api-keys.index') }}" class="btn btn-outline btn-lg gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                                </svg>
                                Lihat API Keys ({{ $apiKeysCount }})
                            </a>
                        @else
                            <a href="{{ route('api-keys.index') }}" class="btn btn-secondary btn-lg gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                                Generate API Key
                            </a>
                        @endif
                        
                        <a href="{{ route('settings.index') }}" class="btn btn-outline btn-lg gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            Pengaturan QRIS
                        </a>
                        
                        <a href="{{ route('documentation.index') }}" class="btn btn-outline btn-lg gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Dokumentasi API
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Status Cards -->
        <div class="space-y-4">
            <!-- QRIS Status -->
            <div class="card bg-base-100 shadow">
                <div class="card-body">
                    <h3 class="card-title text-base">Status QRIS</h3>
                    @if($qrisStatus['uploaded'] && $qrisStatus['has_payload'])
                        <div class="flex items-center gap-2">
                            <div class="badge badge-success gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Active
                            </div>
                        </div>
                        @if($qrisStatus['name'])
                            <p class="text-sm text-base-content/70">{{ $qrisStatus['name'] }}</p>
                        @endif
                    @else
                        <div class="alert alert-warning py-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-5 w-5" fill="none" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                            <span class="text-xs">QRIS belum diupload</span>
                        </div>
                        <a href="{{ route('settings.index') }}" class="btn btn-sm btn-primary">Upload QRIS</a>
                    @endif
                </div>
            </div>
            
            <!-- API Keys Info -->
            <div class="card bg-base-100 shadow">
                <div class="card-body">
                    <h3 class="card-title text-base">API Keys</h3>
                    <div class="stat-value text-2xl">{{ $apiKeysCount }}</div>
                    <p class="text-sm text-base-content/70">Active keys</p>
                    @if($apiKeysCount == 0)
                        <a href="{{ route('api-keys.index') }}" class="btn btn-sm btn-primary mt-2">Create API Key</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('transactionChart').getContext('2d');
        
        // Data from controller
        const chartData = {!! json_encode($chartData ?? ['daily' => ['labels' => [], 'data' => []], 'monthly' => ['labels' => [], 'data' => []]]) !!};
        
        let currentChart = null;
        
        function initChart(type) {
            if (currentChart) {
                currentChart.destroy();
            }
            
            const data = chartData[type];
            
            currentChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: data.labels,
                    datasets: [{
                        label: 'Total Transaksi (Rp)',
                        data: data.data,
                        borderColor: '#3b82f6', // Blue-500
                        backgroundColor: 'rgba(59, 130, 246, 0.1)', // Blue-500 with opacity
                        borderWidth: 2,
                        tension: 0.4,
                        fill: true,
                        pointBackgroundColor: '#3b82f6',
                        pointRadius: 4,
                        pointHoverRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let label = context.dataset.label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    if (context.parsed.y !== null) {
                                        label += new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(context.parsed.y);
                                    }
                                    return label;
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value, index, values) {
                                    return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumSignificantDigits: 3 }).format(value);
                                }
                            },
                            grid: {
                                color: 'hsla(var(--bc) / 0.1)'
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });
            
            // Update buttons
            document.getElementById('btn-daily').classList.toggle('btn-active', type === 'daily');
            document.getElementById('btn-monthly').classList.toggle('btn-active', type === 'monthly');
        }
        
        // Event Listeners
        document.getElementById('btn-daily').addEventListener('click', function() {
            initChart('daily');
        });
        
        document.getElementById('btn-monthly').addEventListener('click', function() {
            initChart('monthly');
        });
        
        // Initialize with daily data
        initChart('daily');
    });
</script>
@endpush
