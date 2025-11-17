@extends('layouts.app')

@section('title', 'Transaksi')

@section('content')
<div class="space-y-6">
    <!-- Stats Widgets -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="stats shadow">
            <div class="stat">
                <div class="stat-figure text-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                    </svg>
                </div>
                <div class="stat-title">Total QRIS</div>
                <div class="stat-value text-primary">1,234</div>
                <div class="stat-desc">↗︎ 12% dari bulan lalu</div>
            </div>
        </div>
        
        <div class="stats shadow">
            <div class="stat">
                <div class="stat-figure text-secondary">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="stat-title">Total Pendapatan</div>
                <div class="stat-value text-secondary">Rp 45,6M</div>
                <div class="stat-desc">↗︎ 8% dari bulan lalu</div>
            </div>
        </div>
    </div>
    
    <!-- Table Section -->
    <div class="card bg-base-100 shadow">
        <div class="card-body">
            <!-- Header with Search and Actions -->
            <div class="flex flex-col md:flex-row gap-4 mb-4">
                <div class="flex-1">
                    <div class="form-control">
                        <div class="input-group flex gap-3">
                            <input type="text" placeholder="Cari transaksi..." class="input input-bordered w-full" />
                            <button class="btn btn-square">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
                
                <div class="flex gap-2">
                    <button class="btn btn-outline gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Export
                    </button>
                    <button class="btn btn-primary gap-2" onclick="create_modal.showModal()">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Create
                    </button>
                </div>
            </div>
            
            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Amount</th>
                            <th>Link</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <div class="font-semibold">Rp 150.000</div>
                            </td>
                            <td>
                                <div class="flex items-center gap-2">
                                    <span class="text-sm truncate max-w-xs">https://qris.id/abc123def456</span>
                                    <button class="btn btn-ghost btn-xs">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                            <td>
                                <div class="text-sm">2024-11-17 10:30:00</div>
                            </td>
                            <td>
                                <div class="flex gap-2">
                                    <button class="btn btn-ghost btn-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </button>
                                    <button class="btn btn-ghost btn-sm text-error">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="font-semibold">Rp 250.000</div>
                            </td>
                            <td>
                                <div class="flex items-center gap-2">
                                    <span class="text-sm truncate max-w-xs">https://qris.id/xyz789ghi012</span>
                                    <button class="btn btn-ghost btn-xs">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                            <td>
                                <div class="text-sm">2024-11-17 10:25:00</div>
                            </td>
                            <td>
                                <div class="flex gap-2">
                                    <button class="btn btn-ghost btn-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </button>
                                    <button class="btn btn-ghost btn-sm text-error">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="font-semibold">Rp 75.000</div>
                            </td>
                            <td>
                                <div class="flex items-center gap-2">
                                    <span class="text-sm truncate max-w-xs">https://qris.id/mno345pqr678</span>
                                    <button class="btn btn-ghost btn-xs">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                            <td>
                                <div class="text-sm">2024-11-17 10:20:00</div>
                            </td>
                            <td>
                                <div class="flex gap-2">
                                    <button class="btn btn-ghost btn-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </button>
                                    <button class="btn btn-ghost btn-sm text-error">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="flex justify-center mt-4">
                <div class="join">
                    <button class="join-item btn btn-sm">«</button>
                    <button class="join-item btn btn-sm btn-active">1</button>
                    <button class="join-item btn btn-sm">2</button>
                    <button class="join-item btn btn-sm">3</button>
                    <button class="join-item btn btn-sm">»</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Create Transaction Modal -->
<dialog id="create_modal" class="modal">
    <div class="modal-box">
        <h3 class="font-bold text-lg mb-4">Buat Transaksi Baru</h3>
        
        <form method="dialog">
            <div class="form-control w-full">
                <label class="label">
                    <span class="label-text">Nominal</span>
                </label>
                <input type="number" placeholder="Masukkan nominal" class="input input-bordered w-full" />
            </div>
            
            <div class="modal-action">
                <button type="button" class="btn btn-ghost" onclick="create_modal.close()">Cancel</button>
                <button type="submit" class="btn btn-primary">Create</button>
            </div>
        </form>
    </div>
    <form method="dialog" class="modal-backdrop">
        <button>close</button>
    </form>
</dialog>
@endsection
