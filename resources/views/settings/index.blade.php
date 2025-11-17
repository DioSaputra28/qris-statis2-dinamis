@extends('layouts.app')

@section('title', 'Pengaturan')

@section('content')
<div class="space-y-6">
    <!-- QRIS Statis Section -->
    <div class="card bg-base-100 shadow">
        <div class="card-body">
            <h2 class="card-title mb-4">QRIS Statis</h2>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- QRIS Preview with 3D Effect -->
                <div class="flex justify-center items-center">
                    <div class="hover-3d">
                        <!-- content -->
                        <figure class="w-60 rounded-2xl">
                            <img src="https://img.daisyui.com/images/stock/card-1.webp?x" alt="QRIS Code" class="rounded-2xl" />
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
                
                <!-- Form Section -->
                <div class="flex flex-col justify-center">
                    <form class="space-y-4">
                        <div class="form-control w-full">
                            <label class="label">
                                <span class="label-text font-semibold">Upload QRIS Statis</span>
                            </label>
                            <input type="file" class="file-input file-input-bordered w-full" accept="image/*" />
                            <label class="label">
                                <span class="label-text-alt">Format: JPG, PNG, atau JPEG (Max: 2MB)</span>
                            </label>
                        </div>
                        
                        <div class="flex gap-3">
                            <button type="button" class="btn btn-error gap-2">
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
@endsection
