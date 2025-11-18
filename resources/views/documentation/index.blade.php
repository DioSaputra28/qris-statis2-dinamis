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
                    <code class="text-sm">{{ url('/api') }}</code>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Authentication -->
    <div class="card bg-base-100 shadow">
        <div class="card-body">
            <h3 class="card-title">Authentication</h3>
            <p class="text-base-content/70">Semua request API memerlukan API Key yang dikirim melalui header Authorization.</p>
            
            <div class="mockup-code mt-4">
                <pre data-prefix="$"><code>Authorization: Bearer sk_live_YOUR_API_KEY_HERE</code></pre>
            </div>
            
            <div class="space-y-3 mt-4">
                <div class="alert alert-info">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="stroke-current shrink-0 w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div class="text-sm">
                        <p class="font-semibold">Format API Key</p>
                        <p>API Key dimulai dengan <code>sk_live_</code> diikuti 32 karakter random.</p>
                        <p class="mt-1">Contoh: <code class="text-xs">sk_live_{32_random_characters}</code></p>
                    </div>
                </div>
                
                <div class="alert alert-warning">
                    <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 w-6 h-6" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <div class="text-sm">
                        <p class="font-semibold">Penting!</p>
                        <ul class="list-disc list-inside mt-1 space-y-1">
                            <li>API Key hanya ditampilkan <strong>sekali</strong> saat dibuat</li>
                            <li>Simpan API Key di tempat yang aman (password manager)</li>
                            <li>Jangan share API Key ke orang lain</li>
                            <li>Jika hilang, buat API Key baru di halaman <a href="{{ route('api-keys.index') }}" class="link font-semibold">API Keys</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- API Endpoint 1: Create Transaction (Link) -->
    <div class="card bg-base-100 shadow">
        <div class="card-body">
            <div class="flex items-center gap-2 mb-2">
                <span class="badge badge-success">POST</span>
                <code class="text-lg font-semibold">/transactions/create-link</code>
            </div>
            <p class="text-base-content/70 mb-4">Generate QRIS transaction dan return link untuk pembayaran.</p>
            
            <!-- Parameters -->
            <h4 class="font-semibold mb-2">Request Body</h4>
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
                            <td>Nominal transaksi (min: 1000)</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <!-- Code Examples with Dropdown -->
            <h4 class="font-semibold mb-2">Request Example</h4>
            <div class="flex gap-2 mb-2">
                <select class="select select-bordered select-sm" onchange="showCode('link', this.value)">
                    <option value="curl">cURL</option>
                    <option value="javascript">JavaScript</option>
                    <option value="php">PHP</option>
                    <option value="python">Python</option>
                </select>
            </div>
            
            <div id="link-curl" class="code-example">
                <div class="mockup-code">
                    <pre data-prefix="$"><code>curl -X POST {{ url('/api/transactions/create-link') }} \</code></pre>
                    <pre data-prefix=""><code>  -H "Authorization: Bearer YOUR_API_KEY" \</code></pre>
                    <pre data-prefix=""><code>  -H "Content-Type: application/json" \</code></pre>
                    <pre data-prefix=""><code>  -d '{"amount": 150000}'</code></pre>
                </div>
            </div>
            
            <div id="link-javascript" class="code-example hidden">
                <div class="mockup-code">
                    <pre data-prefix=""><code>const response = await fetch('{{ url('/api/transactions/create-link') }}', {</code></pre>
                    <pre data-prefix=""><code>  method: 'POST',</code></pre>
                    <pre data-prefix=""><code>  headers: {</code></pre>
                    <pre data-prefix=""><code>    'Authorization': 'Bearer YOUR_API_KEY',</code></pre>
                    <pre data-prefix=""><code>    'Content-Type': 'application/json'</code></pre>
                    <pre data-prefix=""><code>  },</code></pre>
                    <pre data-prefix=""><code>  body: JSON.stringify({ amount: 150000 })</code></pre>
                    <pre data-prefix=""><code>});</code></pre>
                    <pre data-prefix=""><code>const data = await response.json();</code></pre>
                </div>
            </div>
            
            <div id="link-php" class="code-example hidden">
                <div class="mockup-code">
                    <pre data-prefix=""><code>$ch = curl_init('{{ url('/api/transactions/create-link') }}');</code></pre>
                    <pre data-prefix=""><code>curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);</code></pre>
                    <pre data-prefix=""><code>curl_setopt($ch, CURLOPT_POST, true);</code></pre>
                    <pre data-prefix=""><code>curl_setopt($ch, CURLOPT_HTTPHEADER, [</code></pre>
                    <pre data-prefix=""><code>    'Authorization: Bearer YOUR_API_KEY',</code></pre>
                    <pre data-prefix=""><code>    'Content-Type: application/json'</code></pre>
                    <pre data-prefix=""><code>]);</code></pre>
                    <pre data-prefix=""><code>curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([</code></pre>
                    <pre data-prefix=""><code>    'amount' => 150000</code></pre>
                    <pre data-prefix=""><code>]));</code></pre>
                    <pre data-prefix=""><code>$response = curl_exec($ch);</code></pre>
                    <pre data-prefix=""><code>$data = json_decode($response, true);</code></pre>
                </div>
            </div>
            
            <div id="link-python" class="code-example hidden">
                <div class="mockup-code">
                    <pre data-prefix=""><code>import requests</code></pre>
                    <pre data-prefix=""><code></code></pre>
                    <pre data-prefix=""><code>response = requests.post(</code></pre>
                    <pre data-prefix=""><code>    '{{ url('/api/transactions/create-link') }}',</code></pre>
                    <pre data-prefix=""><code>    headers={</code></pre>
                    <pre data-prefix=""><code>        'Authorization': 'Bearer YOUR_API_KEY',</code></pre>
                    <pre data-prefix=""><code>        'Content-Type': 'application/json'</code></pre>
                    <pre data-prefix=""><code>    },</code></pre>
                    <pre data-prefix=""><code>    json={'amount': 150000}</code></pre>
                    <pre data-prefix=""><code>)</code></pre>
                    <pre data-prefix=""><code>data = response.json()</code></pre>
                </div>
            </div>
            
            <!-- Response Tabs -->
            <h4 class="font-semibold mb-2 mt-4">Response</h4>
            <div role="tablist" class="tabs tabs-bordered">
                <input type="radio" name="link_response_tabs" role="tab" class="tab" aria-label="Success (201)" checked />
                <div role="tabpanel" class="tab-content p-4">
                    <div class="mockup-code">
                        <pre data-prefix=""><code>{</code></pre>
                        <pre data-prefix=""><code>  "success": true,</code></pre>
                        <pre data-prefix=""><code>  "message": "Transaction created successfully",</code></pre>
                        <pre data-prefix=""><code>  "data": {</code></pre>
                        <pre data-prefix=""><code>    "transaction_id": "019a9532-b368-7224-b0f9-645cbf938ccc",</code></pre>
                        <pre data-prefix=""><code>    "amount": 150000,</code></pre>
                        <pre data-prefix=""><code>    "qris_url": "{{ url('/qris/abc123def456') }}",</code></pre>
                        <pre data-prefix=""><code>    "created_at": "2024-11-18T10:30:00+07:00"</code></pre>
                        <pre data-prefix=""><code>  }</code></pre>
                        <pre data-prefix=""><code>}</code></pre>
                    </div>
                </div>
                
                <input type="radio" name="link_response_tabs" role="tab" class="tab" aria-label="Error (401)" />
                <div role="tabpanel" class="tab-content p-4">
                    <div class="mockup-code">
                        <pre data-prefix=""><code>{</code></pre>
                        <pre data-prefix=""><code>  "success": false,</code></pre>
                        <pre data-prefix=""><code>  "message": "Invalid API Key."</code></pre>
                        <pre data-prefix=""><code>}</code></pre>
                    </div>
                </div>
                
                <input type="radio" name="link_response_tabs" role="tab" class="tab" aria-label="Error (422)" />
                <div role="tabpanel" class="tab-content p-4">
                    <div class="mockup-code">
                        <pre data-prefix=""><code>{</code></pre>
                        <pre data-prefix=""><code>  "success": false,</code></pre>
                        <pre data-prefix=""><code>  "message": "Validation error",</code></pre>
                        <pre data-prefix=""><code>  "errors": {</code></pre>
                        <pre data-prefix=""><code>    "amount": ["The amount field is required."]</code></pre>
                        <pre data-prefix=""><code>  }</code></pre>
                        <pre data-prefix=""><code>}</code></pre>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- API Endpoint 2: Create Transaction (QR Code) -->
    <div class="card bg-base-100 shadow">
        <div class="card-body">
            <div class="flex items-center gap-2 mb-2">
                <span class="badge badge-success">POST</span>
                <code class="text-lg font-semibold">/transactions/create-qrcode</code>
            </div>
            <p class="text-base-content/70 mb-4">Generate QRIS transaction dan return QR code sebagai base64 image.</p>
            
            <!-- Parameters -->
            <h4 class="font-semibold mb-2">Request Body</h4>
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
                            <td>Nominal transaksi (min: 1000)</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <!-- Code Examples with Dropdown -->
            <h4 class="font-semibold mb-2">Request Example</h4>
            <div class="flex gap-2 mb-2">
                <select class="select select-bordered select-sm" onchange="showCode('qrcode', this.value)">
                    <option value="curl">cURL</option>
                    <option value="javascript">JavaScript</option>
                    <option value="php">PHP</option>
                    <option value="python">Python</option>
                </select>
            </div>
            
            <div id="qrcode-curl" class="code-example">
                <div class="mockup-code">
                    <pre data-prefix="$"><code>curl -X POST {{ url('/api/transactions/create-qrcode') }} \</code></pre>
                    <pre data-prefix=""><code>  -H "Authorization: Bearer YOUR_API_KEY" \</code></pre>
                    <pre data-prefix=""><code>  -H "Content-Type: application/json" \</code></pre>
                    <pre data-prefix=""><code>  -d '{"amount": 150000}'</code></pre>
                </div>
            </div>
            
            <div id="qrcode-javascript" class="code-example hidden">
                <div class="mockup-code">
                    <pre data-prefix=""><code>const response = await fetch('{{ url('/api/transactions/create-qrcode') }}', {</code></pre>
                    <pre data-prefix=""><code>  method: 'POST',</code></pre>
                    <pre data-prefix=""><code>  headers: {</code></pre>
                    <pre data-prefix=""><code>    'Authorization': 'Bearer YOUR_API_KEY',</code></pre>
                    <pre data-prefix=""><code>    'Content-Type': 'application/json'</code></pre>
                    <pre data-prefix=""><code>  },</code></pre>
                    <pre data-prefix=""><code>  body: JSON.stringify({ amount: 150000 })</code></pre>
                    <pre data-prefix=""><code>});</code></pre>
                    <pre data-prefix=""><code>const data = await response.json();</code></pre>
                    <pre data-prefix=""><code>// Display QR Code</code></pre>
                    <pre data-prefix=""><code>document.getElementById('qr').src = `data:image/png;base64,${data.data.qr_code_base64}`;</code></pre>
                </div>
            </div>
            
            <div id="qrcode-php" class="code-example hidden">
                <div class="mockup-code">
                    <pre data-prefix=""><code>$ch = curl_init('{{ url('/api/transactions/create-qrcode') }}');</code></pre>
                    <pre data-prefix=""><code>curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);</code></pre>
                    <pre data-prefix=""><code>curl_setopt($ch, CURLOPT_POST, true);</code></pre>
                    <pre data-prefix=""><code>curl_setopt($ch, CURLOPT_HTTPHEADER, [</code></pre>
                    <pre data-prefix=""><code>    'Authorization: Bearer YOUR_API_KEY',</code></pre>
                    <pre data-prefix=""><code>    'Content-Type: application/json'</code></pre>
                    <pre data-prefix=""><code>]);</code></pre>
                    <pre data-prefix=""><code>curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([</code></pre>
                    <pre data-prefix=""><code>    'amount' => 150000</code></pre>
                    <pre data-prefix=""><code>]));</code></pre>
                    <pre data-prefix=""><code>$response = curl_exec($ch);</code></pre>
                    <pre data-prefix=""><code>$data = json_decode($response, true);</code></pre>
                    <pre data-prefix=""><code>// Display QR Code</code></pre>
                    <pre data-prefix=""><code>echo '&lt;img src="data:image/png;base64,' . $data['data']['qr_code_base64'] . '" /&gt;';</code></pre>
                </div>
            </div>
            
            <div id="qrcode-python" class="code-example hidden">
                <div class="mockup-code">
                    <pre data-prefix=""><code>import requests</code></pre>
                    <pre data-prefix=""><code>import base64</code></pre>
                    <pre data-prefix=""><code></code></pre>
                    <pre data-prefix=""><code>response = requests.post(</code></pre>
                    <pre data-prefix=""><code>    '{{ url('/api/transactions/create-qrcode') }}',</code></pre>
                    <pre data-prefix=""><code>    headers={</code></pre>
                    <pre data-prefix=""><code>        'Authorization': 'Bearer YOUR_API_KEY',</code></pre>
                    <pre data-prefix=""><code>        'Content-Type': 'application/json'</code></pre>
                    <pre data-prefix=""><code>    },</code></pre>
                    <pre data-prefix=""><code>    json={'amount': 150000}</code></pre>
                    <pre data-prefix=""><code>)</code></pre>
                    <pre data-prefix=""><code>data = response.json()</code></pre>
                    <pre data-prefix=""><code># Save QR Code</code></pre>
                    <pre data-prefix=""><code>with open('qris.png', 'wb') as f:</code></pre>
                    <pre data-prefix=""><code>    f.write(base64.b64decode(data['data']['qr_code_base64']))</code></pre>
                </div>
            </div>
            
            <!-- Response Tabs -->
            <h4 class="font-semibold mb-2 mt-4">Response</h4>
            <div role="tablist" class="tabs tabs-bordered">
                <input type="radio" name="qrcode_response_tabs" role="tab" class="tab" aria-label="Success (201)" checked />
                <div role="tabpanel" class="tab-content p-4">
                    <div class="mockup-code">
                        <pre data-prefix=""><code>{</code></pre>
                        <pre data-prefix=""><code>  "success": true,</code></pre>
                        <pre data-prefix=""><code>  "message": "Transaction created successfully",</code></pre>
                        <pre data-prefix=""><code>  "data": {</code></pre>
                        <pre data-prefix=""><code>    "transaction_id": "019a9532-b368-7224-b0f9-645cbf938ccc",</code></pre>
                        <pre data-prefix=""><code>    "amount": 150000,</code></pre>
                        <pre data-prefix=""><code>    "qris_url": "{{ url('/qris/abc123def456') }}",</code></pre>
                        <pre data-prefix=""><code>    "qr_code_base64": "iVBORw0KGgoAAAANSUhEUgAA...",</code></pre>
                        <pre data-prefix=""><code>    "created_at": "2024-11-18T10:30:00+07:00"</code></pre>
                        <pre data-prefix=""><code>  }</code></pre>
                        <pre data-prefix=""><code>}</code></pre>
                    </div>
                </div>
                
                <input type="radio" name="qrcode_response_tabs" role="tab" class="tab" aria-label="Error (500)" />
                <div role="tabpanel" class="tab-content p-4">
                    <div class="mockup-code">
                        <pre data-prefix=""><code>{</code></pre>
                        <pre data-prefix=""><code>  "success": false,</code></pre>
                        <pre data-prefix=""><code>  "message": "Internal server error",</code></pre>
                        <pre data-prefix=""><code>  "error": "Error details here"</code></pre>
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
                            <th>Message</th>
                            <th>Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><span class="badge badge-error">401</span></td>
                            <td>Unauthorized</td>
                            <td>API key tidak valid atau tidak ditemukan</td>
                        </tr>
                        <tr>
                            <td><span class="badge badge-error">404</span></td>
                            <td>Not Found</td>
                            <td>QRIS belum diupload atau payload tidak ditemukan</td>
                        </tr>
                        <tr>
                            <td><span class="badge badge-warning">422</span></td>
                            <td>Validation Error</td>
                            <td>Data yang dikirim tidak valid</td>
                        </tr>
                        <tr>
                            <td><span class="badge badge-error">500</span></td>
                            <td>Internal Server Error</td>
                            <td>Terjadi kesalahan di server</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
function showCode(endpoint, language) {
    // Hide all code examples for this endpoint
    const examples = document.querySelectorAll(`[id^="${endpoint}-"]`);
    examples.forEach(example => {
        example.classList.add('hidden');
    });
    
    // Show selected language
    const selected = document.getElementById(`${endpoint}-${language}`);
    if (selected) {
        selected.classList.remove('hidden');
    }
}
</script>
@endsection
