<?php

namespace App\Exports;

use App\Models\Transaction;
use App\Models\Qris;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TransactionsExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithColumnWidths
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $user = Auth::user();
        $qris = Qris::where('user_id', $user->user_id)->first();
        
        if (!$qris) {
            return collect([]);
        }
        
        return Transaction::with('qris')
            ->where('qris_id', $qris->qris_id)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'Transaction ID',
            'Amount',
            'URL',
            'Total Click',
            'QRIS Name',
            'Created At',
        ];
    }

    /**
     * @param mixed $transaction
     * @return array
     */
    public function map($transaction): array
    {
        return [
            $transaction->transaction_id,
            'Rp ' . number_format($transaction->amount, 0, ',', '.'),
            $transaction->url,
            $transaction->total_click,
            $transaction->qris->name ?? '-',
            $transaction->created_at->format('Y-m-d H:i:s'),
        ];
    }

    /**
     * @param Worksheet $sheet
     * @return array
     */
    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }

    /**
     * @return array
     */
    public function columnWidths(): array
    {
        return [
            'A' => 40,
            'B' => 20,
            'C' => 50,
            'D' => 15,
            'E' => 25,
            'F' => 20,
        ];
    }
}
