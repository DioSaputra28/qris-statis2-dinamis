<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>QRIS Payment - {{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-base-200">
    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="card w-full max-w-md bg-base-100 shadow-xl">
            <div class="card-body items-center text-center">
                <!-- Logo -->
                <div class="w-16 h-16 bg-primary rounded-2xl flex items-center justify-center shadow-lg mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-primary-content" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                    </svg>
                </div>
                
                <h2 class="card-title text-2xl">Pembayaran QRIS</h2>
                
                @if($qris->name)
                    <p class="text-base-content/70">{{ $qris->name }}</p>
                @endif
                
                <!-- Amount -->
                <div class="my-6">
                    <p class="text-base-content/60 text-sm mb-2">Total Pembayaran</p>
                    <p class="text-4xl font-bold text-primary">Rp {{ number_format($transaction->amount, 0, ',', '.') }}</p>
                </div>
                
                <!-- QR Code -->
                <div class="bg-white p-6 rounded-2xl shadow-inner mb-4">
                    <img src="data:image/png;base64,{{ $qrCodeBase64 }}" alt="QRIS Code" class="w-64 h-64 mx-auto" />
                </div>
                
                <!-- Instructions -->
                <div class="alert alert-info">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="stroke-current shrink-0 w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div class="text-left text-sm">
                        <p class="font-semibold mb-1">Cara Pembayaran:</p>
                        <ol class="list-decimal list-inside space-y-1">
                            <li>Buka aplikasi e-wallet atau mobile banking Anda</li>
                            <li>Pilih menu Scan QR atau QRIS</li>
                            <li>Scan kode QR di atas</li>
                            <li>Nominal akan otomatis terisi</li>
                            <li>Konfirmasi pembayaran</li>
                        </ol>
                    </div>
                </div>
                
                <!-- Transaction Info -->
                <div class="divider"></div>
                <div class="text-xs text-base-content/60">
                    <p>Transaction ID: {{ $transaction->transaction_id }}</p>
                    <p>Created: {{ $transaction->created_at->format('d M Y H:i') }}</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Footer -->
    <div class="text-center pb-8">
        <p class="text-sm text-base-content/60">
            Powered by {{ config('app.name') }}
        </p>
    </div>
</body>
</html>
