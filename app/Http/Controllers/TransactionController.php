<?php

namespace App\Http\Controllers;

use App\Models\Qris;
use App\Models\Transaction;
use App\Exports\TransactionsExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        
        // Get user's QRIS
        $qris = Qris::where('user_id', $user->user_id)->first();
        
        // Get transactions with pagination
        $transactions = Transaction::when($qris, function ($query) use ($qris) {
            return $query->where('qris_id', $qris->qris_id);
        })
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        // Calculate stats
        $totalQris = $qris ? Transaction::where('qris_id', $qris->qris_id)->count() : 0;
        $totalRevenue = $qris ? Transaction::where('qris_id', $qris->qris_id)->sum('amount') : 0;
        
        return view('transactions.index', compact('transactions', 'totalQris', 'totalRevenue'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|integer|min:1000',
        ]);

        $user = Auth::user();
        
        // Get user's QRIS
        $qris = Qris::where('user_id', $user->user_id)->first();
        
        if (!$qris) {
            return redirect()->route('transactions.index')
                ->with('error', 'Anda belum memiliki QRIS. Silakan tambahkan QRIS terlebih dahulu di halaman Pengaturan.');
        }

        // Generate unique URL
        $uniqueId = Str::random(12);
        $url = url('/qris/' . $uniqueId);

        // Create transaction
        Transaction::create([
            'url' => $url,
            'amount' => $request->amount,
            'qris_id' => $qris->qris_id,
            'total_click' => 0,
        ]);

        return redirect()->route('transactions.index')
            ->with('success', 'Transaksi berhasil dibuat!');
    }

    /**
     * Display the specified resource (AJAX).
     */
    public function show($id)
    {
        $user = Auth::user();
        $qris = Qris::where('user_id', $user->user_id)->first();
        
        $transaction = Transaction::where('transaction_id', $id)
            ->where('qris_id', $qris->qris_id)
            ->firstOrFail();

        return response()->json([
            'success' => true,
            'data' => [
                'transaction_id' => $transaction->transaction_id,
                'amount' => 'Rp ' . number_format($transaction->amount, 0, ',', '.'),
                'url' => $transaction->url,
                'created_at' => $transaction->created_at->format('d M Y H:i:s'),
            ],
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = Auth::user();
        $qris = Qris::where('user_id', $user->user_id)->first();
        
        $transaction = Transaction::where('transaction_id', $id)
            ->where('qris_id', $qris->qris_id)
            ->firstOrFail();

        $transaction->delete();

        return redirect()->route('transactions.index')
            ->with('success', 'Transaksi berhasil dihapus!');
    }

    /**
     * Export transactions to Excel.
     */
    public function export()
    {
        $fileName = 'transactions_' . date('Y-m-d_His') . '.xlsx';
        
        return Excel::download(new TransactionsExport, $fileName);
    }

    /**
     * Display public QRIS page with dynamic amount.
     */
    public function showQris($uniqueId)
    {
        // Extract unique ID from URL
        $url = url('/qris/' . $uniqueId);
        
        // Find transaction by URL
        $transaction = Transaction::where('url', $url)->firstOrFail();
        
        // Increment click counter
        $transaction->incrementClick();
        
        // Get QRIS with payload
        $qris = Qris::findOrFail($transaction->qris_id);
        
        if (!$qris->qr_code) {
            abort(404, 'QRIS payload not found. Please re-upload QRIS in settings.');
        }

        try {
            // Get original payload from database (no need to decode image)
            $originalPayload = $qris->qr_code;
            
            // Modify payload with dynamic amount
            $modifiedPayload = $this->modifyQrisPayload($originalPayload, $transaction->amount);
            
            // Generate new QR code with modified payload
            $qrCodeImage = \SimpleSoftwareIO\QrCode\Facades\QrCode::format('png')
                ->size(300)
                ->margin(1)
                ->generate($modifiedPayload);
            
            // Convert to base64 for display
            $qrCodeBase64 = base64_encode($qrCodeImage);
            
            return view('qris', [
                'transaction' => $transaction,
                'qris' => $qris,
                'qrCodeBase64' => $qrCodeBase64,
            ]);
            
        } catch (\Exception $e) {
            abort(500, 'Failed to generate dynamic QRIS: ' . $e->getMessage());
        }
    }

    /**
     * Modify QRIS payload to inject dynamic amount.
     * 
     * QRIS menggunakan format EMV (Tag-Length-Value):
     * - Tag 54 = Transaction Amount
     * - Format: 54 + [length] + [amount as integer]
     * 
     * Contoh: 540525000 berarti:
     * - 54 = tag untuk amount
     * - 05 = panjang value (5 karakter)
     * - 25000 = nominal Rp 25.000 (integer, tanpa desimal)
     */
    private function modifyQrisPayload($payload, $amount)
    {
        // Format amount as integer string (no decimals)
        $amountStr = (string) $amount;
        $amountLength = strlen($amountStr);
        
        // Create tag 54 with amount
        $tag54 = '54' . str_pad($amountLength, 2, '0', STR_PAD_LEFT) . $amountStr;
        
        // Remove existing tag 54 if present using TLV parsing
        $payload = $this->removeTag($payload, '54');
        
        // Find position to insert tag 54 (before tag 63 - CRC)
        // Tag 63 adalah CRC checksum yang selalu di akhir
        $tag63Position = strpos($payload, '6304');
        
        if ($tag63Position === false) {
            throw new \Exception('Invalid QRIS format: CRC tag not found');
        }
        
        // Insert tag 54 before tag 63
        $modifiedPayload = substr($payload, 0, $tag63Position) . $tag54 . substr($payload, $tag63Position);
        
        // Recalculate CRC (tag 63)
        // CRC harus dihitung ulang setelah payload dimodifikasi
        $payloadWithoutCrc = substr($modifiedPayload, 0, -4); // Remove old CRC
        $newCrc = $this->calculateCrc16($payloadWithoutCrc);
        
        return $payloadWithoutCrc . $newCrc;
    }

    /**
     * Remove specific tag from QRIS payload using TLV parsing.
     * 
     * @param string $payload QRIS payload
     * @param string $tagToRemove Tag ID to remove (e.g., '54')
     * @return string Payload without the specified tag
     */
    private function removeTag($payload, $tagToRemove)
    {
        $position = 0;
        $result = '';
        
        while ($position < strlen($payload)) {
            // Read tag (2 characters)
            if ($position + 2 > strlen($payload)) {
                break;
            }
            
            $tag = substr($payload, $position, 2);
            $position += 2;
            
            // Read length (2 characters)
            if ($position + 2 > strlen($payload)) {
                break;
            }
            
            $length = (int) substr($payload, $position, 2);
            $position += 2;
            
            // Read value
            if ($position + $length > strlen($payload)) {
                break;
            }
            
            $value = substr($payload, $position, $length);
            $position += $length;
            
            // Keep all tags except the one we want to remove
            if ($tag !== $tagToRemove) {
                $result .= $tag . str_pad($length, 2, '0', STR_PAD_LEFT) . $value;
            }
        }
        
        return $result;
    }

    /**
     * Calculate CRC-16/CCITT-FALSE for QRIS.
     * 
     * QRIS menggunakan CRC-16 CCITT-FALSE algorithm:
     * - Polynomial: 0x1021
     * - Initial value: 0xFFFF
     * - No XOR output
     * - Output: 4 digit hex uppercase
     */
    private function calculateCrc16($data)
    {
        $crc = 0xFFFF;
        $polynomial = 0x1021;
        
        for ($i = 0; $i < strlen($data); $i++) {
            $crc ^= (ord($data[$i]) << 8);
            
            for ($j = 0; $j < 8; $j++) {
                if ($crc & 0x8000) {
                    $crc = ($crc << 1) ^ $polynomial;
                } else {
                    $crc = $crc << 1;
                }
                $crc &= 0xFFFF;
            }
        }
        
        // Convert to 4-digit hex uppercase with leading zeros
        return strtoupper(str_pad(dechex($crc), 4, '0', STR_PAD_LEFT));
    }
}
