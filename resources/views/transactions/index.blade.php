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
                <div class="stat-value text-primary">{{ number_format($totalQris) }}</div>
                <div class="stat-desc">Total transaksi yang dibuat</div>
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
                <div class="stat-value text-secondary">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
                <div class="stat-desc">Total nominal transaksi</div>
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
                    <a href="{{ route('transactions.export') }}" class="btn btn-outline gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Export
                    </a>
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
                            <th>No</th>
                            <th>Amount</th>
                            <th>Link</th>
                            <th>Total Click</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transactions as $index => $transaction)
                            <tr>
                                <td>{{ $transactions->firstItem() + $index }}</td>
                                <td>
                                    <div class="font-semibold">Rp {{ number_format($transaction->amount, 0, ',', '.') }}</div>
                                </td>
                                <td>
                                    <div class="flex items-center gap-2">
                                        <span class="text-sm truncate max-w-xs">{{ $transaction->url }}</span>
                                        <button class="btn btn-ghost btn-xs" onclick="copyToClipboard('{{ $transaction->url }}')" title="Copy">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                                <td>
                                    <div class="badge badge-ghost">{{ number_format($transaction->total_click) }}</div>
                                </td>
                                <td>
                                    <div class="text-sm">{{ $transaction->created_at->format('Y-m-d H:i:s') }}</div>
                                </td>
                                <td>
                                    <div class="flex gap-2">
                                        <button class="btn btn-ghost btn-sm" onclick="showTransaction('{{ $transaction->transaction_id }}')">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </button>
                                        <button class="btn btn-ghost btn-sm text-error" onclick="confirmDelete('{{ $transaction->transaction_id }}')">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-8 text-base-content/60">
                                    Belum ada transaksi
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            @if($transactions->hasPages())
                <div class="flex justify-center mt-4">
                    {{ $transactions->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Create Transaction Modal -->
<dialog id="create_modal" class="modal">
    <div class="modal-box">
        <h3 class="font-bold text-lg mb-4">Buat Transaksi Baru</h3>
        
        <form action="{{ route('transactions.store') }}" method="POST" id="create-transaction-form">
            @csrf
            <div class="form-control w-full">
                <label class="label">
                    <span class="label-text">Nominal (Rp)</span>
                </label>
                <input 
                    type="text" 
                    id="amount-display" 
                    placeholder="Masukkan nominal" 
                    class="input input-bordered w-full @error('amount') input-error @enderror" 
                    required 
                />
                <input type="hidden" name="amount" id="amount-value" />
                @error('amount')
                    <label class="label">
                        <span class="label-text-alt text-error">{{ $message }}</span>
                    </label>
                @else
                    <label class="label">
                        <span class="label-text-alt">Minimal Rp 1.000 - Format otomatis: 1.000.000</span>
                    </label>
                @enderror
            </div>
            
            <div class="modal-action">
                <button type="button" class="btn btn-ghost" onclick="closeCreateModal()">Cancel</button>
                <button type="submit" class="btn btn-primary">Create</button>
            </div>
        </form>
    </div>
    <form method="dialog" class="modal-backdrop">
        <button>close</button>
    </form>
</dialog>

<!-- Show Transaction Modal -->
<dialog id="show_modal" class="modal">
    <div class="modal-box max-w-2xl">
        <form method="dialog">
            <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
        </form>
        <h3 class="font-bold text-2xl mb-6">Detail Transaksi</h3>
        
        <div id="transaction-detail" class="space-y-4">
            <div class="flex justify-center py-8">
                <span class="loading loading-spinner loading-lg"></span>
            </div>
        </div>
        
        <div class="modal-action">
            <button type="button" class="btn btn-primary" onclick="show_modal.close()">Tutup</button>
        </div>
    </div>
    <form method="dialog" class="modal-backdrop">
        <button>close</button>
    </form>
</dialog>

<!-- Delete Confirmation Modal -->
<dialog id="delete_modal" class="modal">
    <div class="modal-box">
        <h3 class="font-bold text-lg">Konfirmasi Hapus</h3>
        <p class="py-4">Apakah Anda yakin ingin menghapus transaksi ini?</p>
        <div class="modal-action">
            <button type="button" class="btn btn-ghost" onclick="delete_modal.close()">Batal</button>
            <form id="delete-form" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-error">Hapus</button>
            </form>
        </div>
    </div>
    <form method="dialog" class="modal-backdrop">
        <button>close</button>
    </form>
</dialog>

<script>
// Show toast notification
function showToast(message, type = 'success') {
    const toast = document.createElement('div');
    const iconSvg = type === 'success' 
        ? `<svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
           </svg>`
        : `<svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
           </svg>`;
    
    toast.className = `alert alert-${type} fixed bottom-4 right-4 w-auto shadow-lg z-50 animate-in slide-in-from-bottom-5`;
    toast.innerHTML = `${iconSvg}<span>${message}</span>`;
    document.body.appendChild(toast);
    
    setTimeout(() => {
        toast.classList.add('animate-out', 'slide-out-to-bottom-5');
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}

// Show session messages as toast
@if(session('success'))
    document.addEventListener('DOMContentLoaded', function() {
        showToast('{{ session('success') }}');
    });
@endif

@if(session('error'))
    document.addEventListener('DOMContentLoaded', function() {
        showToast('{{ session('error') }}', 'error');
    });
@endif

// Show transaction detail with AJAX
function showTransaction(id) {
    const modal = document.getElementById('show_modal');
    const detailContainer = document.getElementById('transaction-detail');
    
    // Show loading
    detailContainer.innerHTML = '<div class="flex justify-center"><span class="loading loading-spinner loading-lg"></span></div>';
    modal.showModal();
    
    // Fetch transaction detail
    fetch(`/transactions/${id}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                detailContainer.innerHTML = `
                    <div class="bg-base-200 rounded-lg p-6 space-y-5">
                        <!-- Transaction ID -->
                        <div class="space-y-2">
                            <label class="text-sm font-semibold text-base-content/70 uppercase tracking-wide">ID Transaksi</label>
                            <div class="bg-base-100 rounded-lg p-3 border border-base-300">
                                <p class="text-sm font-mono break-all">${data.data.transaction_id}</p>
                            </div>
                        </div>
                        
                        <!-- Amount -->
                        <div class="space-y-2">
                            <label class="text-sm font-semibold text-base-content/70 uppercase tracking-wide">Nominal</label>
                            <div class="bg-base-100 rounded-lg p-4 border border-base-300">
                                <p class="text-2xl font-bold text-primary">${data.data.amount}</p>
                            </div>
                        </div>
                        
                        <!-- QRIS Link -->
                        <div class="space-y-2">
                            <label class="text-sm font-semibold text-base-content/70 uppercase tracking-wide">Link QRIS</label>
                            <div class="flex gap-2">
                                <div class="bg-base-100 rounded-lg p-3 border border-base-300 flex-1 overflow-hidden">
                                    <p class="text-sm break-all">${data.data.url}</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Created At -->
                        <div class="space-y-2">
                            <label class="text-sm font-semibold text-base-content/70 uppercase tracking-wide">Dibuat Pada</label>
                            <div class="bg-base-100 rounded-lg p-3 border border-base-300 flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-base-content/50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <p class="text-sm">${data.data.created_at}</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Quick Actions -->
                    <div class="flex gap-2 mt-6">
                        <a href="${data.data.url}" target="_blank" class="btn btn-outline btn-primary flex-1 gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                            </svg>
                            Buka Link
                        </a>
                        <button onclick="copyToClipboard('${data.data.url}')" class="btn btn-outline flex-1 gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                            </svg>
                            Copy Link
                        </button>
                    </div>
                `;
            }
        })
        .catch(error => {
            detailContainer.innerHTML = '<div class="alert alert-error"><span>Gagal memuat data transaksi</span></div>';
        });
}

// Confirm delete
function confirmDelete(id) {
    const form = document.getElementById('delete-form');
    form.action = `/transactions/${id}`;
    document.getElementById('delete_modal').showModal();
}

// Copy to clipboard with toast notification
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(() => {
        showToast('Link berhasil disalin!');
    }).catch(() => {
        showToast('Gagal menyalin link', 'error');
    });
}

// Number formatting for amount input
document.addEventListener('DOMContentLoaded', function() {
    const amountDisplay = document.getElementById('amount-display');
    const amountValue = document.getElementById('amount-value');
    
    if (amountDisplay) {
        amountDisplay.addEventListener('input', function(e) {
            // Remove all non-digit characters
            let value = e.target.value.replace(/\D/g, '');
            
            // Update hidden input with raw number
            amountValue.value = value;
            
            // Format display with thousand separators
            if (value) {
                e.target.value = formatNumber(value);
            } else {
                e.target.value = '';
            }
        });
        
        amountDisplay.addEventListener('keypress', function(e) {
            // Only allow numbers
            if (e.key && !/[0-9]/.test(e.key)) {
                e.preventDefault();
            }
        });
    }
});

// Format number with thousand separators
function formatNumber(num) {
    return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
}

// Close create modal and reset form
function closeCreateModal() {
    document.getElementById('create-transaction-form').reset();
    document.getElementById('amount-value').value = '';
    create_modal.close();
}
</script>
@endsection
