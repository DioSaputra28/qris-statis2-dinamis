@extends('layouts.app')

@section('title', 'Dokumentasi API')

@section('content')
<div class="space-y-6">
    <!-- Introduction -->
    <div class="card bg-base-100 shadow">
        <div class="card-body">
            <h2 class="card-title text-2xl">Dokumentasi API QRIS Dinamis</h2>
            <p class="text-base-content/70">Panduan lengkap untuk mengintegrasikan API QRIS Dinamis ke aplikasi Anda.</p>
            
            <div class="alert alert-info mt-4">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="stroke-current shrink-0 w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div>
                    <div class="font-semibold">Base URL</div>
                    <code class="text-sm">https://api.qrisdinamis.com/v1</code>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Authentication -->
    <div class="card bg-base-100 shadow">
        <div class="card-body">
            <h3 class="card-title">Authentication</h3>
            <p class="text-base-content/70">Semua request API memerlukan API Key yang dikirim melalui header.</p>
            
            <div class="mockup-code mt-4">
                <pre data-prefix="$"><code>curl -H "Authorization: Bearer YOUR_API_KEY"</code></pre>
            </div>
        </div>
    </div>
    
    <!-- API Endpoint 1: Generate QRIS -->
    <div class="card bg-base-100 shadow">
        <div class="card-body">
            <div class="flex items-center gap-2 mb-2">
                <span class="badge badge-success">POST</span>
                <code class="text-lg font-semibold">/qris/generate</code>
            </div>
            <p class="text-base-content/70 mb-4">Generate QRIS dinamis dengan nominal tertentu.</p>
            
            <!-- Parameters -->
            <h4 class="font-semibold mb-2">Parameters</h4>
            <div class="overflow-x-auto mb-4">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>Parameter</th>
                            <th>Type</th>
                            <th>Required</th>
                            <th>Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><code>amount</code></td>
                            <td>integer</td>
                            <td><span class="badge badge-error badge-sm">Yes</span></td>
                            <td>Nominal transaksi dalam Rupiah</td>
                        </tr>
                        <tr>
                            <td><code>description</code></td>
                            <td>string</td>
                            <td><span class="badge badge-ghost badge-sm">No</span></td>
                            <td>Deskripsi transaksi</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <!-- Request Example -->
            <h4 class="font-semibold mb-2">Request Example</h4>
            <div class="mockup-code mb-4">
                <pre data-prefix="$"><code>curl -X POST https://api.qrisdinamis.com/v1/qris/generate \</code></pre>
                <pre data-prefix=""><code>  -H "Authorization: Bearer YOUR_API_KEY" \</code></pre>
                <pre data-prefix=""><code>  -H "Content-Type: application/json" \</code></pre>
                <pre data-prefix=""><code>  -d '{"amount": 150000, "description": "Pembayaran Invoice #123"}'</code></pre>
            </div>
            
            <!-- Response Tabs -->
            <h4 class="font-semibold mb-2">Response</h4>
            <div role="tablist" class="tabs tabs-bordered">
                <input type="radio" name="generate_tabs" role="tab" class="tab" aria-label="Success" checked />
                <div role="tabpanel" class="tab-content p-4">
                    <div class="mockup-code">
                        <pre data-prefix=""><code>{</code></pre>
                        <pre data-prefix=""><code>  "success": true,</code></pre>
                        <pre data-prefix=""><code>  "message": "QRIS generated successfully",</code></pre>
                        <pre data-prefix=""><code>  "data": {</code></pre>
                        <pre data-prefix=""><code>    "id": "qris_abc123def456",</code></pre>
                        <pre data-prefix=""><code>    "amount": 150000,</code></pre>
                        <pre data-prefix=""><code>    "qris_url": "https://qris.id/abc123def456",</code></pre>
                        <pre data-prefix=""><code>    "qris_image": "https://api.qrisdinamis.com/qr/abc123.png",</code></pre>
                        <pre data-prefix=""><code>    "expired_at": "2024-11-17T11:30:00Z",</code></pre>
                        <pre data-prefix=""><code>    "status": "pending"</code></pre>
                        <pre data-prefix=""><code>  }</code></pre>
                        <pre data-prefix=""><code>}</code></pre>
                    </div>
                </div>
                
                <input type="radio" name="generate_tabs" role="tab" class="tab" aria-label="Error" />
                <div role="tabpanel" class="tab-content p-4">
                    <div class="mockup-code">
                        <pre data-prefix=""><code>{</code></pre>
                        <pre data-prefix=""><code>  "success": false,</code></pre>
                        <pre data-prefix=""><code>  "message": "Validation error",</code></pre>
                        <pre data-prefix=""><code>  "errors": {</code></pre>
                        <pre data-prefix=""><code>    "amount": [</code></pre>
                        <pre data-prefix=""><code>      "The amount field is required."</code></pre>
                        <pre data-prefix=""><code>    ]</code></pre>
                        <pre data-prefix=""><code>  }</code></pre>
                        <pre data-prefix=""><code>}</code></pre>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- API Endpoint 2: Check Status -->
    <div class="card bg-base-100 shadow">
        <div class="card-body">
            <div class="flex items-center gap-2 mb-2">
                <span class="badge badge-info">GET</span>
                <code class="text-lg font-semibold">/qris/status/:id</code>
            </div>
            <p class="text-base-content/70 mb-4">Cek status pembayaran QRIS.</p>
            
            <!-- Parameters -->
            <h4 class="font-semibold mb-2">Parameters</h4>
            <div class="overflow-x-auto mb-4">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>Parameter</th>
                            <th>Type</th>
                            <th>Required</th>
                            <th>Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><code>id</code></td>
                            <td>string</td>
                            <td><span class="badge badge-error badge-sm">Yes</span></td>
                            <td>ID transaksi QRIS</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <!-- Request Example -->
            <h4 class="font-semibold mb-2">Request Example</h4>
            <div class="mockup-code mb-4">
                <pre data-prefix="$"><code>curl -X GET https://api.qrisdinamis.com/v1/qris/status/qris_abc123def456 \</code></pre>
                <pre data-prefix=""><code>  -H "Authorization: Bearer YOUR_API_KEY"</code></pre>
            </div>
            
            <!-- Response Tabs -->
            <h4 class="font-semibold mb-2">Response</h4>
            <div role="tablist" class="tabs tabs-bordered">
                <input type="radio" name="status_tabs" role="tab" class="tab" aria-label="Success" checked />
                <div role="tabpanel" class="tab-content p-4">
                    <div class="mockup-code">
                        <pre data-prefix=""><code>{</code></pre>
                        <pre data-prefix=""><code>  "success": true,</code></pre>
                        <pre data-prefix=""><code>  "message": "Transaction found",</code></pre>
                        <pre data-prefix=""><code>  "data": {</code></pre>
                        <pre data-prefix=""><code>    "id": "qris_abc123def456",</code></pre>
                        <pre data-prefix=""><code>    "amount": 150000,</code></pre>
                        <pre data-prefix=""><code>    "status": "paid",</code></pre>
                        <pre data-prefix=""><code>    "paid_at": "2024-11-17T10:45:00Z",</code></pre>
                        <pre data-prefix=""><code>    "payment_method": "QRIS"</code></pre>
                        <pre data-prefix=""><code>  }</code></pre>
                        <pre data-prefix=""><code>}</code></pre>
                    </div>
                </div>
                
                <input type="radio" name="status_tabs" role="tab" class="tab" aria-label="Error" />
                <div role="tabpanel" class="tab-content p-4">
                    <div class="mockup-code">
                        <pre data-prefix=""><code>{</code></pre>
                        <pre data-prefix=""><code>  "success": false,</code></pre>
                        <pre data-prefix=""><code>  "message": "Transaction not found",</code></pre>
                        <pre data-prefix=""><code>  "error": {</code></pre>
                        <pre data-prefix=""><code>    "code": "NOT_FOUND",</code></pre>
                        <pre data-prefix=""><code>    "details": "The requested transaction does not exist"</code></pre>
                        <pre data-prefix=""><code>  }</code></pre>
                        <pre data-prefix=""><code>}</code></pre>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- API Endpoint 3: Get Transactions -->
    <div class="card bg-base-100 shadow">
        <div class="card-body">
            <div class="flex items-center gap-2 mb-2">
                <span class="badge badge-info">GET</span>
                <code class="text-lg font-semibold">/transactions</code>
            </div>
            <p class="text-base-content/70 mb-4">Dapatkan daftar semua transaksi.</p>
            
            <!-- Parameters -->
            <h4 class="font-semibold mb-2">Query Parameters</h4>
            <div class="overflow-x-auto mb-4">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>Parameter</th>
                            <th>Type</th>
                            <th>Required</th>
                            <th>Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><code>page</code></td>
                            <td>integer</td>
                            <td><span class="badge badge-ghost badge-sm">No</span></td>
                            <td>Nomor halaman (default: 1)</td>
                        </tr>
                        <tr>
                            <td><code>limit</code></td>
                            <td>integer</td>
                            <td><span class="badge badge-ghost badge-sm">No</span></td>
                            <td>Jumlah data per halaman (default: 10)</td>
                        </tr>
                        <tr>
                            <td><code>status</code></td>
                            <td>string</td>
                            <td><span class="badge badge-ghost badge-sm">No</span></td>
                            <td>Filter berdasarkan status (pending, paid, expired)</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <!-- Request Example -->
            <h4 class="font-semibold mb-2">Request Example</h4>
            <div class="mockup-code mb-4">
                <pre data-prefix="$"><code>curl -X GET "https://api.qrisdinamis.com/v1/transactions?page=1&limit=10" \</code></pre>
                <pre data-prefix=""><code>  -H "Authorization: Bearer YOUR_API_KEY"</code></pre>
            </div>
            
            <!-- Response Tabs -->
            <h4 class="font-semibold mb-2">Response</h4>
            <div role="tablist" class="tabs tabs-bordered">
                <input type="radio" name="transactions_tabs" role="tab" class="tab" aria-label="Success" checked />
                <div role="tabpanel" class="tab-content p-4">
                    <div class="mockup-code">
                        <pre data-prefix=""><code>{</code></pre>
                        <pre data-prefix=""><code>  "success": true,</code></pre>
                        <pre data-prefix=""><code>  "data": [</code></pre>
                        <pre data-prefix=""><code>    {</code></pre>
                        <pre data-prefix=""><code>      "id": "qris_abc123",</code></pre>
                        <pre data-prefix=""><code>      "amount": 150000,</code></pre>
                        <pre data-prefix=""><code>      "status": "paid",</code></pre>
                        <pre data-prefix=""><code>      "created_at": "2024-11-17T10:30:00Z"</code></pre>
                        <pre data-prefix=""><code>    }</code></pre>
                        <pre data-prefix=""><code>  ],</code></pre>
                        <pre data-prefix=""><code>  "pagination": {</code></pre>
                        <pre data-prefix=""><code>    "current_page": 1,</code></pre>
                        <pre data-prefix=""><code>    "total_pages": 5,</code></pre>
                        <pre data-prefix=""><code>    "total_items": 50</code></pre>
                        <pre data-prefix=""><code>  }</code></pre>
                        <pre data-prefix=""><code>}</code></pre>
                    </div>
                </div>
                
                <input type="radio" name="transactions_tabs" role="tab" class="tab" aria-label="Error" />
                <div role="tabpanel" class="tab-content p-4">
                    <div class="mockup-code">
                        <pre data-prefix=""><code>{</code></pre>
                        <pre data-prefix=""><code>  "success": false,</code></pre>
                        <pre data-prefix=""><code>  "message": "Unauthorized",</code></pre>
                        <pre data-prefix=""><code>  "error": {</code></pre>
                        <pre data-prefix=""><code>    "code": "UNAUTHORIZED",</code></pre>
                        <pre data-prefix=""><code>    "details": "Invalid or expired API key"</code></pre>
                        <pre data-prefix=""><code>  }</code></pre>
                        <pre data-prefix=""><code>}</code></pre>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Error Codes -->
    <div class="card bg-base-100 shadow">
        <div class="card-body">
            <h3 class="card-title">Error Codes</h3>
            <div class="overflow-x-auto mt-4">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Code</th>
                            <th>Status</th>
                            <th>Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><code>UNAUTHORIZED</code></td>
                            <td><span class="badge badge-error">401</span></td>
                            <td>API key tidak valid atau expired</td>
                        </tr>
                        <tr>
                            <td><code>NOT_FOUND</code></td>
                            <td><span class="badge badge-warning">404</span></td>
                            <td>Resource tidak ditemukan</td>
                        </tr>
                        <tr>
                            <td><code>VALIDATION_ERROR</code></td>
                            <td><span class="badge badge-warning">422</span></td>
                            <td>Data yang dikirim tidak valid</td>
                        </tr>
                        <tr>
                            <td><code>RATE_LIMIT</code></td>
                            <td><span class="badge badge-error">429</span></td>
                            <td>Terlalu banyak request</td>
                        </tr>
                        <tr>
                            <td><code>SERVER_ERROR</code></td>
                            <td><span class="badge badge-error">500</span></td>
                            <td>Internal server error</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
