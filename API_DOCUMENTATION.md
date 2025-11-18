# API Documentation - QRIS Dinamis

## Base URL
```
http://your-domain.com/api
```

## Authentication
Semua API endpoint memerlukan API Key yang dikirim melalui header `Authorization`.

```
Authorization: Bearer YOUR_API_KEY
```

atau

```
Authorization: YOUR_API_KEY
```

## Endpoints

### 1. Create Transaction (Return Link)
Generate QRIS transaction dan return link untuk pembayaran.

**Endpoint:** `POST /transactions/create-link`

**Headers:**
```
Authorization: Bearer sk_live_xxxxxxxxxxxxx
Content-Type: application/json
```

**Request Body:**
```json
{
  "amount": 150000
}
```

**Parameters:**
- `amount` (required, integer, min: 1000): Nominal transaksi dalam Rupiah

**Success Response (201):**
```json
{
  "success": true,
  "message": "Transaction created successfully",
  "data": {
    "transaction_id": "019a9532-b368-7224-b0f9-645cbf938ccc",
    "amount": 150000,
    "qris_url": "http://your-domain.com/qris/abc123def456",
    "created_at": "2024-11-18T10:30:00+07:00"
  }
}
```

**Error Responses:**

401 Unauthorized (Missing API Key):
```json
{
  "success": false,
  "message": "API Key is required. Please provide Authorization header."
}
```

401 Unauthorized (Invalid API Key):
```json
{
  "success": false,
  "message": "Invalid API Key."
}
```

404 Not Found (QRIS not uploaded):
```json
{
  "success": false,
  "message": "QRIS not found. Please upload QRIS in settings first."
}
```

422 Validation Error:
```json
{
  "message": "The amount field is required.",
  "errors": {
    "amount": [
      "The amount field is required."
    ]
  }
}
```

---

### 2. Create Transaction (Return QR Code Base64)
Generate QRIS transaction dan return QR code sebagai base64 image.

**Endpoint:** `POST /transactions/create-qrcode`

**Headers:**
```
Authorization: Bearer sk_live_xxxxxxxxxxxxx
Content-Type: application/json
```

**Request Body:**
```json
{
  "amount": 150000
}
```

**Parameters:**
- `amount` (required, integer, min: 1000): Nominal transaksi dalam Rupiah

**Success Response (201):**
```json
{
  "success": true,
  "message": "Transaction created successfully",
  "data": {
    "transaction_id": "019a9532-b368-7224-b0f9-645cbf938ccc",
    "amount": 150000,
    "qris_url": "http://your-domain.com/qris/abc123def456",
    "qr_code_base64": "iVBORw0KGgoAAAANSUhEUgAA...(base64 string)",
    "created_at": "2024-11-18T10:30:00+07:00"
  }
}
```

**QR Code Usage:**
```html
<img src="data:image/png;base64,{qr_code_base64}" alt="QRIS" />
```

**Error Responses:**
Same as endpoint #1, plus:

500 Internal Server Error (QR generation failed):
```json
{
  "success": false,
  "message": "Failed to generate QRIS: [error details]"
}
```

---

## Example Usage

### cURL Example (Create Link)
```bash
curl -X POST http://your-domain.com/api/transactions/create-link \
  -H "Authorization: Bearer sk_live_xxxxxxxxxxxxx" \
  -H "Content-Type: application/json" \
  -d '{"amount": 150000}'
```

### cURL Example (Create QR Code)
```bash
curl -X POST http://your-domain.com/api/transactions/create-qrcode \
  -H "Authorization: Bearer sk_live_xxxxxxxxxxxxx" \
  -H "Content-Type: application/json" \
  -d '{"amount": 150000}'
```

### PHP Example
```php
<?php

$apiKey = 'sk_live_xxxxxxxxxxxxx';
$amount = 150000;

$ch = curl_init('http://your-domain.com/api/transactions/create-link');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Authorization: Bearer ' . $apiKey,
    'Content-Type: application/json',
]);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
    'amount' => $amount,
]));

$response = curl_exec($ch);
$result = json_decode($response, true);

if ($result['success']) {
    echo "QRIS URL: " . $result['data']['qris_url'];
} else {
    echo "Error: " . $result['message'];
}

curl_close($ch);
```

### JavaScript Example (Fetch API)
```javascript
const apiKey = 'sk_live_xxxxxxxxxxxxx';
const amount = 150000;

fetch('http://your-domain.com/api/transactions/create-link', {
  method: 'POST',
  headers: {
    'Authorization': `Bearer ${apiKey}`,
    'Content-Type': 'application/json',
  },
  body: JSON.stringify({ amount })
})
.then(response => response.json())
.then(data => {
  if (data.success) {
    console.log('QRIS URL:', data.data.qris_url);
  } else {
    console.error('Error:', data.message);
  }
})
.catch(error => console.error('Error:', error));
```

---

## Rate Limiting
- Setiap API call akan di-track di kolom `total_call` pada API Key
- Belum ada rate limiting, tapi bisa ditambahkan di masa depan

## Notes
- Nominal minimal: Rp 1.000
- QR Code yang di-generate sudah include nominal (QRIS dinamis)
- Customer tidak perlu input nominal saat scan
- Link QRIS bisa dibuka oleh siapa saja (public)
- Setiap kali link dibuka, `total_click` akan bertambah
