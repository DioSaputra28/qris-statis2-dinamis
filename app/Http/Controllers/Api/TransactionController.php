<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Qris;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TransactionController extends Controller
{
    /**
     * Create transaction and return QRIS link.
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createLink(Request $request)
    {
        try {
            // Validate input
            $request->validate([
                'amount' => 'required|integer|min:1000',
            ]);

            // Get API key record from middleware
            $apiKeyRecord = $request->input('api_key_record');
            
            // Get user's QRIS
            $qris = Qris::where('user_id', $apiKeyRecord->user_id)->first();
            
            if (!$qris) {
                return response()->json([
                    'success' => false,
                    'message' => 'QRIS not found. Please upload QRIS in settings first.',
                ], 404);
            }

            if (!$qris->qr_code) {
                return response()->json([
                    'success' => false,
                    'message' => 'QRIS payload not found. Please re-upload QRIS in settings.',
                ], 404);
            }

            // Generate unique URL
            $uniqueId = Str::random(12);
            $url = url('/qris/' . $uniqueId);

            // Create transaction
            $transaction = Transaction::create([
                'url' => $url,
                'amount' => $request->amount,
                'qris_id' => $qris->qris_id,
                'total_click' => 0,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Transaction created successfully',
                'data' => [
                    'transaction_id' => $transaction->transaction_id,
                    'amount' => $transaction->amount,
                    'qris_url' => $transaction->url,
                    'created_at' => $transaction->created_at->toIso8601String(),
                ],
            ], 201);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $e->errors(),
            ], 422);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Internal server error',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Create transaction and return QRIS as base64 image.
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createQrCode(Request $request)
    {
        try {
            // Validate input
            $request->validate([
                'amount' => 'required|integer|min:1000',
            ]);

            // Get API key record from middleware
            $apiKeyRecord = $request->input('api_key_record');
            
            // Get user's QRIS
            $qris = Qris::where('user_id', $apiKeyRecord->user_id)->first();
            
            if (!$qris) {
                return response()->json([
                    'success' => false,
                    'message' => 'QRIS not found. Please upload QRIS in settings first.',
                ], 404);
            }

            if (!$qris->qr_code) {
                return response()->json([
                    'success' => false,
                    'message' => 'QRIS payload not found. Please re-upload QRIS in settings.',
                ], 404);
            }

            // Generate unique URL
            $uniqueId = Str::random(12);
            $url = url('/qris/' . $uniqueId);

            // Create transaction
            $transaction = Transaction::create([
                'url' => $url,
                'amount' => $request->amount,
                'qris_id' => $qris->qris_id,
                'total_click' => 0,
            ]);

            try {
                // Get original payload from database
                $originalPayload = $qris->qr_code;
                
                // Modify payload with dynamic amount
                $modifiedPayload = $this->modifyQrisPayload($originalPayload, $transaction->amount);
                
                // Generate QR code
                $qrCodeImage = \SimpleSoftwareIO\QrCode\Facades\QrCode::format('png')
                    ->size(300)
                    ->margin(1)
                    ->generate($modifiedPayload);
                
                // Convert to base64
                $qrCodeBase64 = base64_encode($qrCodeImage);
                
                return response()->json([
                    'success' => true,
                    'message' => 'Transaction created successfully',
                    'data' => [
                        'transaction_id' => $transaction->transaction_id,
                        'amount' => $transaction->amount,
                        'qris_url' => $transaction->url,
                        'qr_code_base64' => $qrCodeBase64,
                        'created_at' => $transaction->created_at->toIso8601String(),
                    ],
                ], 201);
                
            } catch (\Exception $e) {
                // Delete transaction if QR generation fails
                $transaction->delete();
                
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to generate QRIS',
                    'error' => $e->getMessage(),
                ], 500);
            }
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $e->errors(),
            ], 422);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Internal server error',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Modify QRIS payload to inject dynamic amount.
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
        $tag63Position = strpos($payload, '6304');
        
        if ($tag63Position === false) {
            throw new \Exception('Invalid QRIS format: CRC tag not found');
        }
        
        // Insert tag 54 before tag 63
        $modifiedPayload = substr($payload, 0, $tag63Position) . $tag54 . substr($payload, $tag63Position);
        
        // Recalculate CRC
        $payloadWithoutCrc = substr($modifiedPayload, 0, -4);
        $newCrc = $this->calculateCrc16($payloadWithoutCrc);
        
        return $payloadWithoutCrc . $newCrc;
    }

    /**
     * Remove specific tag from QRIS payload using TLV parsing.
     */
    private function removeTag($payload, $tagToRemove)
    {
        $position = 0;
        $result = '';
        
        while ($position < strlen($payload)) {
            if ($position + 2 > strlen($payload)) {
                break;
            }
            
            $tag = substr($payload, $position, 2);
            $position += 2;
            
            if ($position + 2 > strlen($payload)) {
                break;
            }
            
            $length = (int) substr($payload, $position, 2);
            $position += 2;
            
            if ($position + $length > strlen($payload)) {
                break;
            }
            
            $value = substr($payload, $position, $length);
            $position += $length;
            
            if ($tag !== $tagToRemove) {
                $result .= $tag . str_pad($length, 2, '0', STR_PAD_LEFT) . $value;
            }
        }
        
        return $result;
    }

    /**
     * Calculate CRC-16/CCITT-FALSE for QRIS.
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
        
        return strtoupper(str_pad(dechex($crc), 4, '0', STR_PAD_LEFT));
    }
}
