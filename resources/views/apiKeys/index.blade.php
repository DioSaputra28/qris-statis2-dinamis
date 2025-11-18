@extends('layouts.app')

@section('title', 'API Key')

@section('content')
<div class="space-y-6">
    <!-- Alert Messages -->
    @if(session('success'))
        <div class="alert alert-success">
            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif



    <!-- Table Section -->
    <div class="card bg-base-100 shadow">
        <div class="card-body">
            <!-- Header with Search and Actions -->
            <div class="flex flex-col md:flex-row gap-4 mb-4">
                <div class="flex-1">
                    <form action="{{ route('api-keys.index') }}" method="GET">
                        <div class="form-control">
                            <div class="input-group flex gap-3">
                                <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari nama API Key..." class="input input-bordered w-full" />
                                <button type="submit" class="btn btn-square">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </button>
                                @if($search)
                                    <a href="{{ route('api-keys.index') }}" class="btn btn-ghost">Clear</a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
                
                <div class="flex gap-2">
                    <button class="btn btn-primary gap-2" onclick="create_api_key_modal.showModal()">
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
                            <th>Name</th>
                            <th>Key</th>
                            <th>Created At</th>
                            <th>Total Call</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($apiKeys as $index => $apiKey)
                            <tr>
                                <td>{{ $apiKeys->firstItem() + $index }}</td>
                                <td>
                                    <div class="font-semibold">{{ $apiKey->name }}</div>
                                </td>
                                <td>
                                    <div class="flex items-center gap-2">
                                        <code class="text-sm">{{ $apiKey->masked_key }}</code>
                                        <button class="btn btn-ghost btn-xs" onclick="copyToClipboard('{{ $apiKey->key }}')" title="Copy">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                                <td>
                                    <div class="text-sm">{{ $apiKey->created_at->format('Y-m-d H:i:s') }}</div>
                                </td>
                                <td>
                                    <div class="badge badge-ghost">{{ number_format($apiKey->total_call) }}</div>
                                </td>
                                <td>
                                    <button class="btn btn-ghost btn-sm text-error" onclick="confirmDelete('{{ $apiKey->apikey_id }}')">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-8 text-base-content/60">
                                    @if($search)
                                        Tidak ada API Key dengan nama "{{ $search }}"
                                    @else
                                        Belum ada API Key
                                    @endif
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            @if($apiKeys->hasPages())
                <div class="flex justify-center mt-4">
                    {{ $apiKeys->appends(['search' => $search])->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Create API Key Modal -->
<dialog id="create_api_key_modal" class="modal">
    <div class="modal-box">
        <h3 class="font-bold text-lg mb-4">Buat API Key Baru</h3>
        
        <form action="{{ route('api-keys.store') }}" method="POST">
            @csrf
            <div class="form-control w-full">
                <label class="label">
                    <span class="label-text">Nama API Key</span>
                </label>
                <input type="text" name="name" placeholder="Masukkan nama API Key" class="input input-bordered w-full @error('name') input-error @enderror" required />
                @error('name')
                    <label class="label">
                        <span class="label-text-alt text-error">{{ $message }}</span>
                    </label>
                @else
                    <label class="label">
                        <span class="label-text-alt">Nama ini akan membantu Anda mengidentifikasi API Key</span>
                    </label>
                @enderror
            </div>
            
            <div class="modal-action">
                <button type="button" class="btn btn-ghost" onclick="create_api_key_modal.close()">Cancel</button>
                <button type="submit" class="btn btn-primary">Create</button>
            </div>
        </form>
    </div>
    <form method="dialog" class="modal-backdrop">
        <button>close</button>
    </form>
</dialog>

<!-- Show New API Key Modal -->
<dialog id="new_key_modal" class="modal">
    <div class="modal-box">
        <h3 class="font-bold text-lg mb-4">API Key Berhasil Dibuat!</h3>
        
        <div class="alert alert-warning mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
            <span class="text-sm">Simpan API Key ini dengan aman. Hanya ditampilkan sekali!</span>
        </div>
        
        <div class="form-control">
            <label class="label">
                <span class="label-text font-semibold">API Key Anda:</span>
            </label>
            <div class="flex gap-2">
                <input type="text" id="new-api-key-value" value="{{ session('new_key') }}" class="input input-bordered flex-1 font-mono text-sm" readonly />
                <button class="btn btn-square" onclick="copyNewKey()">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                    </svg>
                </button>
            </div>
        </div>
        
        <div class="modal-action">
            <button type="button" class="btn btn-primary" onclick="new_key_modal.close()">Saya Sudah Menyimpannya</button>
        </div>
    </div>
</dialog>

<!-- Delete Confirmation Modal -->
<dialog id="delete_modal" class="modal">
    <div class="modal-box">
        <h3 class="font-bold text-lg">Konfirmasi Hapus</h3>
        <p class="py-4">Apakah Anda yakin ingin menghapus API Key ini? Aplikasi yang menggunakan key ini akan berhenti bekerja.</p>
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
// Auto-open modal if new key exists
@if(session('new_key'))
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('new_key_modal').showModal();
    });
@endif

// Copy new API key
function copyNewKey() {
    const input = document.getElementById('new-api-key-value');
    input.select();
    navigator.clipboard.writeText(input.value).then(() => {
        alert('API Key berhasil disalin!');
    });
}

// Confirm delete
function confirmDelete(id) {
    const form = document.getElementById('delete-form');
    form.action = `/api-keys/${id}`;
    document.getElementById('delete_modal').showModal();
}

// Copy to clipboard
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(() => {
        alert('API Key berhasil disalin!');
    });
}
</script>
@endsection
