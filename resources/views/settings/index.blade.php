@extends('layouts.app')

@section('title', 'Pengaturan')

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

    @if(session('error'))
        <div class="alert alert-error">
            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <!-- QRIS Statis Section -->
    <div class="card bg-base-100 shadow">
        <div class="card-body">
            <h2 class="card-title mb-4">QRIS Statis</h2>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- QRIS Preview with 3D Effect -->
                @if($qris && $qris->img_url)
                    <div class="flex justify-center items-center">
                        <div class="hover-3d">
                            <!-- content -->
                            <figure class="w-60 rounded-2xl">
                                <img src="{{ asset('storage/' . $qris->img_url) }}" alt="QRIS Code" class="rounded-2xl" />
                            </figure>
                            <!-- 8 empty divs needed for the 3D effect -->
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                        </div>
                    </div>
                @else
                    <div class="flex justify-center items-center">
                        <div class="text-center p-8">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 mx-auto text-base-content/20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <p class="text-base-content/60 mt-4">Belum ada QRIS</p>
                        </div>
                    </div>
                @endif
                
                <!-- Form Section -->
                <div class="flex flex-col justify-center">
                    <form action="{{ $qris ? route('qris.update', $qris->qris_id) : route('qris.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        @if($qris)
                            @method('PUT')
                        @endif
                        
                        <div class="form-control w-full">
                            <label class="label">
                                <span class="label-text font-semibold">Nama QRIS</span>
                            </label>
                            <input type="text" name="name" value="{{ old('name', $qris->name ?? '') }}" placeholder="Contoh: QRIS Toko Saya" class="input input-bordered w-full @error('name') input-error @enderror" required />
                            @error('name')
                                <label class="label">
                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                </label>
                            @else
                                <label class="label">
                                    <span class="label-text-alt">Nama akan ditampilkan di halaman pembayaran</span>
                                </label>
                            @enderror
                        </div>
                        
                        <div class="form-control w-full">
                            <label class="label">
                                <span class="label-text font-semibold">Upload QRIS Statis</span>
                            </label>
                            <input type="file" name="qris_image" class="file-input file-input-bordered w-full @error('qris_image') file-input-error @enderror" accept="image/*" required />
                            @error('qris_image')
                                <label class="label">
                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                </label>
                            @else
                                <label class="label">
                                    <span class="label-text-alt">Format: JPG, PNG, atau JPEG (Max: 2MB). Pastikan upload QR Code QRIS yang valid.</span>
                                </label>
                            @enderror
                        </div>
                        
                        <div class="flex gap-3">
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
                                    Tambah QRIS
                                </button>
                            @endif
                        </div>
                    </form>
                    
                    <div class="alert alert-info mt-6">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="stroke-current shrink-0 w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="text-sm">QRIS statis akan digunakan sebagai default untuk semua transaksi yang tidak memiliki QRIS dinamis.</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

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
