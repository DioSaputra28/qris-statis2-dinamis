@extends('layouts.app')

@section('title', 'Pengaturan')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">
    <!-- Page Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold">Pengaturan QRIS</h1>
            <p class="text-base-content/60 mt-1">Kelola QRIS statis Anda</p>
        </div>

    </div>

    <!-- Main Card -->
    <div class="card bg-base-100 shadow-xl">
        <div class="card-body p-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Preview -->
                <div class="flex flex-col items-center justify-center">
                    @if($qris && $qris->img_url)
                        <div class="w-full max-w-sm">
                            <img src="{{ asset('storage/' . $qris->img_url) }}" alt="QRIS" class="w-full rounded-2xl shadow-lg" />
                            @if($qris->name)
                            <p class="text-center mt-4 font-medium">{{ $qris->name }}</p>
                            @endif
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 mx-auto text-base-content/20 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                            </svg>
                            <p class="text-base-content/60">Belum ada QRIS</p>
                        </div>
                    @endif
                </div>
                
                <!-- Form -->
                <div>
                    <form action="{{ $qris ? route('qris.update', $qris->qris_id) : route('qris.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                        @csrf
                        @if($qris)
                            @method('PUT')
                        @endif
                        
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text font-medium">Nama QRIS</span>
                            </label>
                            <input 
                                type="text" 
                                name="name" 
                                value="{{ old('name', $qris->name ?? '') }}" 
                                placeholder="Contoh: QRIS Toko Saya" 
                                class="input input-bordered w-full @error('name') input-error @enderror" 
                                required 
                            />
                            @error('name')
                                <label class="label">
                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                </label>
                            @enderror
                        </div>
                        
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text font-medium">Upload QRIS</span>
                            </label>
                            <input 
                                type="file" 
                                name="qris_image" 
                                class="file-input file-input-bordered w-full @error('qris_image') file-input-error @enderror" 
                                accept="image/*" 
                                {{ $qris ? '' : 'required' }}
                                onchange="previewImage(event)"
                            />
                            @error('qris_image')
                                <label class="label">
                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                </label>
                            @else
                                <label class="label">
                                    <span class="label-text-alt">JPG, PNG, JPEG • Max 2MB</span>
                                </label>
                            @enderror
                            
                            <div id="imagePreview" class="mt-4 hidden">
                                <img id="preview" class="max-w-xs rounded-lg shadow-lg mx-auto" />
                            </div>
                        </div>
                        
                        <div class="flex gap-3 pt-2">
                            @if($qris)
                                <button type="button" class="btn btn-error gap-2" onclick="delete_modal.showModal()">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                    Hapus
                                </button>
                                <button type="submit" class="btn btn-primary gap-2 flex-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                    </svg>
                                    Update
                                </button>
                            @else
                                <button type="submit" class="btn btn-primary gap-2 w-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                    Simpan
                                </button>
                            @endif
                        </div>
                    </form>
                    
                    <div class="alert alert-info mt-6">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="text-sm">QRIS statis digunakan untuk generate QRIS dinamis dengan nominal berbeda</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Storage Link Helper (for shared hosting) -->
    <div class="card bg-base-100 shadow-xl">
        <div class="card-body">
            <h2 class="card-title">Storage Link Helper</h2>
            <p class="text-sm text-base-content/60">Untuk shared hosting yang tidak bisa akses terminal</p>
            
            <div class="flex flex-col sm:flex-row gap-3 mt-4">
                <button onclick="checkStorageLink()" class="btn btn-outline gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Check Status
                </button>
                <button onclick="createStorageLink()" class="btn btn-primary gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                    </svg>
                    Create Storage Link
                </button>
            </div>
            
            <div id="storageStatus" class="mt-4 hidden"></div>
        </div>
    </div>
</div>

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

// Preview image before upload
function previewImage(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('preview').src = e.target.result;
            document.getElementById('imagePreview').classList.remove('hidden');
        }
        reader.readAsDataURL(file);
    }
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

// Check storage link status
function checkStorageLink() {
    const statusDiv = document.getElementById('storageStatus');
    statusDiv.innerHTML = '<div class="loading loading-spinner loading-sm"></div> Checking...';
    statusDiv.classList.remove('hidden');
    
    fetch('{{ route('storage.link.check') }}')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const status = data.status;
                let alertClass = 'alert-info';
                let message = '';
                
                if (status.is_symlink && status.link_exists) {
                    alertClass = 'alert-success';
                    message = '✓ Storage link exists and working properly';
                } else if (status.link_exists && !status.is_symlink) {
                    alertClass = 'alert-warning';
                    message = '⚠ Storage folder exists but not a symlink. Click "Create Storage Link" to fix.';
                } else {
                    alertClass = 'alert-error';
                    message = '✗ Storage link not found. Click "Create Storage Link" to create it.';
                }
                
                statusDiv.innerHTML = `
                    <div class="alert ${alertClass}">
                        <span class="text-sm">${message}</span>
                    </div>
                `;
            }
        })
        .catch(error => {
            statusDiv.innerHTML = `
                <div class="alert alert-error">
                    <span class="text-sm">Error checking status: ${error.message}</span>
                </div>
            `;
        });
}

// Create storage link
function createStorageLink() {
    const statusDiv = document.getElementById('storageStatus');
    statusDiv.innerHTML = '<div class="loading loading-spinner loading-sm"></div> Creating storage link...';
    statusDiv.classList.remove('hidden');
    
    fetch('{{ route('storage.link.create') }}')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const alertClass = data.type === 'success' ? 'alert-success' : 'alert-info';
                statusDiv.innerHTML = `
                    <div class="alert ${alertClass}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="text-sm">${data.message}</span>
                    </div>
                `;
                showToast(data.message);
            } else {
                statusDiv.innerHTML = `
                    <div class="alert alert-error">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <div class="text-sm">
                            <p class="font-semibold">${data.message}</p>
                            ${data.solution ? `<p class="mt-1">${data.solution}</p>` : ''}
                        </div>
                    </div>
                `;
                showToast(data.message, 'error');
            }
        })
        .catch(error => {
            statusDiv.innerHTML = `
                <div class="alert alert-error">
                    <span class="text-sm">Error: ${error.message}</span>
                </div>
            `;
            showToast('Failed to create storage link', 'error');
        });
}
</script>

<!-- Delete Confirmation Modal -->
@if($qris)
<dialog id="delete_modal" class="modal">
    <div class="modal-box">
        <h3 class="font-bold text-lg">Konfirmasi Hapus</h3>
        <p class="py-4">Apakah Anda yakin ingin menghapus QRIS ini? Tindakan ini tidak dapat dibatalkan.</p>
        <div class="modal-action">
            <form method="dialog">
                <button class="btn btn-ghost">Batal</button>
            </form>
            <form action="{{ route('qris.destroy', $qris->qris_id) }}" method="POST">
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
@endif
@endsection
