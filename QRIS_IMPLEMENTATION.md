# Implementasi QRIS Dinamis

## Penjelasan Konsep

### Apa itu QRIS?
QRIS (Quick Response Code Indonesian Standard) adalah standar nasional kode QR untuk pembayaran digital di Indonesia yang dikembangkan oleh Bank Indonesia dan ASPI (Asosiasi Sistem Pembayaran Indonesia).

### Perbedaan QRIS Statis vs Dinamis

**QRIS Statis:**
- QR code yang sama digunakan untuk semua transaksi
- Nominal pembayaran diinput manual oleh customer saat scan
- Cocok untuk merchant yang tidak perlu kontrol nominal

**QRIS Dinamis:**
- QR code berbeda untuk setiap transaksi
- Nominal sudah ter-embed di QR code
- Customer tidak perlu input nominal, langsung bayar
- Lebih aman dan mengurangi human error

## Struktur QRIS Payload

QRIS menggunakan format **EMV (Tag-Length-Value)** atau **TLV**:

```
[Tag][Length][Value]
```

### Contoh Struktur:
```
00020101          -> Tag 00 (Payload Format Indicator), Length 02, Value 01
01021211          -> Tag 01 (Point of Initiation), Length 02, Value 12
...
540610000.00      -> Tag 54 (Transaction Amount), Length 06, Value 10000.00
5802ID            -> Tag 58 (Country Code), Length 02, Value ID
6304XXXX          -> Tag 63 (CRC), Length 04, Value XXXX (checksum)
```

### Tag Penting:
- **Tag 00**: Payload Format Indicator (selalu "01")
- **Tag 54**: Transaction Amount (nominal transaksi) - **INI YANG KITA MODIFIKASI**
- **Tag 58**: Country Code (ID untuk Indonesia)
- **Tag 63**: CRC-16 Checksum (untuk validasi integritas data)

## Implementasi di Aplikasi

### 1. Package yang Digunakan

#### a. `khanamiryan/qrcode-detector-decoder`
**Fungsi:** Decode QR code image menjadi text payload

**Kenapa pakai ini:**
- Bisa membaca QR code dari file gambar
- Support berbagai format image (PNG, JPG, etc)
- Menggunakan ZXing library yang reliable

**Cara kerja:**
```php
$qrcode = new \Zxing\QrReader($qrisImagePath);
$originalPayload = $qrcode->text(); // Dapat string payload QRIS
```

#### b. `simplesoftwareio/simple-qrcode`
**Fungsi:** Generate QR code dari text/payload

**Kenapa pakai ini:**
- Simple dan mudah digunakan
- Support berbagai format output (PNG, SVG, etc)
- Bisa customize size, margin, dll

**Cara kerja:**
```php
$qrCodeImage = QrCode::format('png')
    ->size(300)
    ->generate($modifiedPayload); // Generate QR dari payload baru
```

### 2. Alur Proses Modifikasi QRIS

```
┌─────────────────┐
│  QRIS Statis    │ (dari database, tidak ada tag 54)
│  (Image File)   │
└────────┬────────┘
         │
         ▼
┌─────────────────┐
│  Decode Image   │ (khanamiryan/qrcode-detector-decoder)
│  → Get Payload  │
└────────┬────────┘
         │
         ▼
┌─────────────────┐
│ Inject Tag 54   │ (tambahkan nominal dari transaction)
│ + Recalculate   │
│   CRC           │
└────────┬────────┘
         │
         ▼
┌─────────────────┐
│ Generate New QR │ (simplesoftwareio/simple-qrcode)
│ with Modified   │
│ Payload         │
└────────┬────────┘
         │
         ▼
┌─────────────────┐
│ Display to User │
└─────────────────┘
```

### 3. Kode Implementasi

#### Method `modifyQrisPayload()`

```php
private function modifyQrisPayload($payload, $amount)
{
    // 1. Format amount ke string dengan 2 desimal
    $amountStr = number_format($amount, 2, '.', '');
    // Contoh: 150000 → "150000.00"
    
    // 2. Hitung panjang string amount
    $amountLength = strlen($amountStr);
    // Contoh: "150000.00" → length = 9
    
    // 3. Buat tag 54 dengan format: 54 + [length] + [amount]
    $tag54 = '54' . str_pad($amountLength, 2, '0', STR_PAD_LEFT) . $amountStr;
    // Contoh: "54" + "09" + "150000.00" = "5409150000.00"
    
    // 4. Hapus tag 54 yang sudah ada (jika QRIS statis punya)
    $payload = preg_replace('/54\d{2}[\d.]+/', '', $payload);
    
    // 5. Cari posisi tag 63 (CRC) - selalu di akhir
    $tag63Position = strpos($payload, '6304');
    
    // 6. Insert tag 54 SEBELUM tag 63
    $modifiedPayload = substr($payload, 0, $tag63Position) 
                     . $tag54 
                     . substr($payload, $tag63Position);
    
    // 7. Hitung ulang CRC karena payload berubah
    $payloadWithoutCrc = substr($modifiedPayload, 0, -4);
    $newCrc = $this->calculateCrc16($payloadWithoutCrc);
    
    return $payloadWithoutCrc . $newCrc;
}
```

#### Method `calculateCrc16()`

**Kenapa perlu CRC?**
- CRC (Cyclic Redundancy Check) adalah checksum untuk validasi data
- Setiap kali payload berubah, CRC harus dihitung ulang
- Jika CRC salah, QR code akan ditolak oleh payment gateway

**Algorithm: CRC-16/CCITT-FALSE**
- Polynomial: 0x1021
- Initial value: 0xFFFF
- Digunakan oleh standar EMV dan QRIS

```php
private function calculateCrc16($data)
{
    $crc = 0xFFFF;  // Initial value
    $polynomial = 0x1021;  // Polynomial untuk CRC-16 CCITT
    
    // Loop setiap karakter di payload
    for ($i = 0; $i < strlen($data); $i++) {
        $crc ^= (ord($data[$i]) << 8);
        
        // Process 8 bits
        for ($j = 0; $j < 8; $j++) {
            if ($crc & 0x8000) {
                $crc = ($crc << 1) ^ $polynomial;
            } else {
                $crc = $crc << 1;
            }
            $crc &= 0xFFFF;
        }
    }
    
    return strtoupper(dechex($crc));
}
```

### 4. Contoh Payload Sebelum dan Sesudah

**QRIS Statis (tanpa tag 54):**
```
00020101021126...5802ID6304ABCD
```

**QRIS Dinamis (dengan tag 54):**
```
00020101021126...5409150000.005802ID6304XYZ1
                  ↑
                  Tag 54 dengan nominal Rp 150.000
```

## Keamanan dan Validasi

1. **Ownership Check**: Hanya user yang punya QRIS bisa buat transaction
2. **URL Unique**: Setiap transaction punya URL unik (12 karakter random)
3. **CRC Validation**: Payment gateway akan validasi CRC sebelum proses
4. **Public Access**: URL `/qris/{uniqueId}` bisa diakses siapa saja (untuk customer)

## Testing

### Manual Test:
1. Login ke aplikasi
2. Buat transaction dengan nominal tertentu
3. Copy URL yang di-generate
4. Buka URL di browser (tanpa login)
5. Scan QR code dengan aplikasi e-wallet
6. Nominal harus sudah terisi otomatis

### Expected Result:
- QR code ter-generate dengan benar
- Nominal sesuai dengan yang diinput
- Aplikasi e-wallet bisa scan dan nominal muncul otomatis

## Referensi

- [ASPI QRIS Standards](https://www.greyamp.com/blogs/decoding-aspi-standards-the-technical-backbone-of-qris-in-indonesia)
- [EMV QR Code Specification](https://www.emvco.com/emv-technologies/qrcodes/)
- [Bank Indonesia QRIS Documentation](https://www.bi.go.id/qris)
