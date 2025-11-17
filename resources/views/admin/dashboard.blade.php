@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="stats shadow">
            <div class="stat">
                <div class="stat-figure text-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block w-8 h-8 stroke-current">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="stat-title">Total Transaksi</div>
                <div class="stat-value text-primary">1,234</div>
                <div class="stat-desc">↗︎ 12% dari bulan lalu</div>
            </div>
        </div>
        
        <div class="stats shadow">
            <div class="stat">
                <div class="stat-figure text-secondary">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block w-8 h-8 stroke-current">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
                    </svg>
                </div>
                <div class="stat-title">Pendapatan</div>
                <div class="stat-value text-secondary">Rp 45,6M</div>
                <div class="stat-desc">↗︎ 8% dari bulan lalu</div>
            </div>
        </div>
        
        <div class="stats shadow">
            <div class="stat">
                <div class="stat-figure text-accent">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block w-8 h-8 stroke-current">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                    </svg>
                </div>
                <div class="stat-title">QRIS Aktif</div>
                <div class="stat-value text-accent">89</div>
                <div class="stat-desc">↗︎ 5 baru hari ini</div>
            </div>
        </div>
        
        <div class="stats shadow">
            <div class="stat">
                <div class="stat-figure text-success">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block w-8 h-8 stroke-current">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                    </svg>
                </div>
                <div class="stat-title">Sukses Rate</div>
                <div class="stat-value text-success">98.5%</div>
                <div class="stat-desc">↗︎ 0.5% dari bulan lalu</div>
            </div>
        </div>
    </div>
    
    <!-- Recent Transactions -->
    <div class="card bg-base-100 shadow">
        <div class="card-body">
            <h2 class="card-title">Transaksi Terbaru</h2>
            <div class="overflow-x-auto">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tanggal</th>
                            <th>Nominal</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>TRX001</td>
                            <td>2024-11-17 10:30</td>
                            <td>Rp 150.000</td>
                            <td><span class="badge badge-success">Berhasil</span></td>
                            <td><button class="btn btn-ghost btn-xs">Detail</button></td>
                        </tr>
                        <tr>
                            <td>TRX002</td>
                            <td>2024-11-17 10:25</td>
                            <td>Rp 250.000</td>
                            <td><span class="badge badge-success">Berhasil</span></td>
                            <td><button class="btn btn-ghost btn-xs">Detail</button></td>
                        </tr>
                        <tr>
                            <td>TRX003</td>
                            <td>2024-11-17 10:20</td>
                            <td>Rp 75.000</td>
                            <td><span class="badge badge-warning">Pending</span></td>
                            <td><button class="btn btn-ghost btn-xs">Detail</button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
