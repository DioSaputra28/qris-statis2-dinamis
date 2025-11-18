<?php

namespace App\Http\Controllers;

use App\Models\Qris;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class QrisController extends Controller
{
    /**
     * Display the settings page with QRIS data.
     */
    public function index()
    {
        $user = Auth::user();
        $qris = Qris::where('user_id', $user->user_id)->first();

        return view('settings.index', compact('qris'));
    }

    /**
     * Store a newly created QRIS in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'qris_image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $user = Auth::user();

        // Check if user already has QRIS
        $existingQris = Qris::where('user_id', $user->user_id)->first();
        if ($existingQris) {
            return redirect()->route('settings.index')
                ->with('error', 'Anda sudah memiliki QRIS. Gunakan tombol Update untuk mengubah.');
        }

        // Upload image
        $imagePath = $request->file('qris_image')->store('qris', 'public');
        $fullPath = storage_path('app/public/' . $imagePath);

        try {
            // Decode QRIS to get payload
            $qrcode = new \Zxing\QrReader($fullPath);
            $qrPayload = $qrcode->text();
            
            // Validate if it's a valid QRIS (check for tag 00 and 63)
            if (!$this->isValidQris($qrPayload)) {
                // Delete uploaded image if not valid QRIS
                Storage::disk('public')->delete($imagePath);
                
                return redirect()->route('settings.index')
                    ->with('error', 'File yang diupload bukan QRIS yang valid. Pastikan Anda mengupload QR Code QRIS.');
            }

            // Create QRIS record with decoded payload
            Qris::create([
                'name' => $request->name,
                'user_id' => $user->user_id,
                'img_url' => $imagePath,
                'qr_code' => $qrPayload,
            ]);

            return redirect()->route('settings.index')
                ->with('success', 'QRIS berhasil ditambahkan!');
                
        } catch (\Exception $e) {
            // Delete uploaded image if decode fails
            Storage::disk('public')->delete($imagePath);
            
            return redirect()->route('settings.index')
                ->with('error', 'Gagal membaca QR Code. Pastikan gambar yang diupload adalah QRIS yang valid.');
        }
    }

    /**
     * Update the specified QRIS in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'qris_image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $user = Auth::user();
        $qris = Qris::where('qris_id', $id)
            ->where('user_id', $user->user_id)
            ->firstOrFail();

        // Upload new image
        $imagePath = $request->file('qris_image')->store('qris', 'public');
        $fullPath = storage_path('app/public/' . $imagePath);

        try {
            // Decode QRIS to get payload
            $qrcode = new \Zxing\QrReader($fullPath);
            $qrPayload = $qrcode->text();
            
            // Validate if it's a valid QRIS
            if (!$this->isValidQris($qrPayload)) {
                // Delete uploaded image if not valid QRIS
                Storage::disk('public')->delete($imagePath);
                
                return redirect()->route('settings.index')
                    ->with('error', 'File yang diupload bukan QRIS yang valid. Pastikan Anda mengupload QR Code QRIS.');
            }

            // Delete old image
            if ($qris->img_url && Storage::disk('public')->exists($qris->img_url)) {
                Storage::disk('public')->delete($qris->img_url);
            }

            // Update QRIS record with new payload
            $qris->update([
                'name' => $request->name,
                'img_url' => $imagePath,
                'qr_code' => $qrPayload,
            ]);

            return redirect()->route('settings.index')
                ->with('success', 'QRIS berhasil diupdate!');
                
        } catch (\Exception $e) {
            // Delete uploaded image if decode fails
            Storage::disk('public')->delete($imagePath);
            
            return redirect()->route('settings.index')
                ->with('error', 'Gagal membaca QR Code. Pastikan gambar yang diupload adalah QRIS yang valid.');
        }
    }

    /**
     * Remove the specified QRIS from storage.
     */
    public function destroy($id)
    {
        $user = Auth::user();
        $qris = Qris::where('qris_id', $id)
            ->where('user_id', $user->user_id)
            ->firstOrFail();

        // Count transactions that will be deleted
        $transactionCount = Transaction::where('qris_id', $qris->qris_id)->count();

        // Delete image from storage
        if ($qris->img_url && Storage::disk('public')->exists($qris->img_url)) {
            Storage::disk('public')->delete($qris->img_url);
        }

        // Delete QRIS record (will cascade delete transactions)
        $qris->delete();

        $message = 'QRIS berhasil dihapus!';
        if ($transactionCount > 0) {
            $message .= " ({$transactionCount} transaksi terkait juga telah dihapus)";
        }

        return redirect()->route('settings.index')
            ->with('success', $message);
    }

    /**
     * Validate if the decoded payload is a valid QRIS.
     * 
     * QRIS harus memiliki:
     * - Tag 00 (Payload Format Indicator) di awal
     * - Tag 63 (CRC) di akhir
     * - Minimal length yang reasonable
     */
    private function isValidQris($payload)
    {
        // Check minimum length
        if (strlen($payload) < 50) {
            return false;
        }

        // Check if starts with tag 00 (Payload Format Indicator)
        if (substr($payload, 0, 2) !== '00') {
            return false;
        }

        // Check if contains tag 63 (CRC) near the end
        if (strpos($payload, '6304') === false) {
            return false;
        }

        // Check if contains tag 58 (Country Code) with value ID
        if (strpos($payload, '5802ID') === false) {
            return false;
        }

        return true;
    }
}
