@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
<div class="space-y-6">
    <!-- Account Settings -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Profile Information -->
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <h2 class="card-title mb-4 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    Informasi Profil
                </h2>

                <div class="space-y-4">
                    <div class="bg-base-200 rounded-lg p-4">
                        <label class="text-xs font-semibold text-base-content/60 uppercase tracking-wide">Nama Lengkap</label>
                        <p class="text-base font-semibold mt-1">{{ $user->name }}</p>
                    </div>

                    <div class="bg-base-200 rounded-lg p-4">
                        <label class="text-xs font-semibold text-base-content/60 uppercase tracking-wide">Email</label>
                        <p class="text-base font-semibold mt-1 break-all">{{ $user->email }}</p>
                    </div>

                    <div class="bg-base-200 rounded-lg p-4">
                        <label class="text-xs font-semibold text-base-content/60 uppercase tracking-wide">Tanggal Bergabung</label>
                        <p class="text-base font-semibold mt-1">{{ $user->created_at->format('d F Y, H:i') }}</p>
                    </div>

                    <div class="bg-base-200 rounded-lg p-4">
                        <label class="text-xs font-semibold text-base-content/60 uppercase tracking-wide">Terakhir Diperbarui</label>
                        <p class="text-base font-semibold mt-1">{{ $user->updated_at->format('d F Y, H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Change Password Form -->
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <h2 class="card-title mb-4 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                    Keamanan Akun
                </h2>

                <form action="{{ route('profile.password.update') }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-semibold">Password Saat Ini</span>
                        </label>
                        <div class="relative">
                            <input
                                type="password"
                                name="current_password"
                                class="input input-bordered w-full pr-10 @error('current_password') input-error @enderror"
                                placeholder="Masukkan password saat ini"
                                required
                            />
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-base-content/30" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </div>
                        </div>
                        @error('current_password')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>

                    <div class="divider text-xs">Password Baru</div>

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-semibold">Password Baru</span>
                        </label>
                        <div class="relative">
                            <input
                                type="password"
                                name="password"
                                class="input input-bordered w-full pr-10 @error('password') input-error @enderror"
                                placeholder="Masukkan password baru"
                                required
                            />
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-base-content/30" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                        </div>
                        @error('password')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @else
                            <label class="label">
                                <span class="label-text-alt">Minimal 8 karakter</span>
                            </label>
                        @enderror
                    </div>

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-semibold">Konfirmasi Password Baru</span>
                        </label>
                        <div class="relative">
                            <input
                                type="password"
                                name="password_confirmation"
                                class="input input-bordered w-full pr-10"
                                placeholder="Konfirmasi password baru"
                                required
                            />
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-base-content/30" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-info">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="stroke-current shrink-0 w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="text-sm">Password harus berbeda dengan password lama dan minimal 8 karakter.</span>
                    </div>

                    <div class="flex gap-2 justify-end mt-6">
                        <button type="reset" class="btn btn-ghost">
                            Reset Form
                        </button>
                        <button type="submit" class="btn btn-primary gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Update Password
                        </button>
                    </div>
                </form>
            </div>
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

@if(session('success'))
    document.addEventListener('DOMContentLoaded', function() {
        showToast('{{ session('success') }}');
    });
@endif

@if($errors->any())
    document.addEventListener('DOMContentLoaded', function() {
        @foreach($errors->all() as $error)
            showToast('{{ $error }}', 'error');
        @endforeach
    });
@endif
</script>
@endsection
