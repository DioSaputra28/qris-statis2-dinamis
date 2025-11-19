<?php

namespace App\Http\Controllers;

use App\Models\ApiKey;
use App\Models\Qris;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $qris = Qris::where('user_id', $user->user_id)->first();
        
        // Get stats
        $stats = [
            // Total Transactions
            'total_transactions_today' => 0,
            'total_transactions_yesterday' => 0,
            'total_transactions_all' => 0,
            
            // Total Revenue
            'total_revenue_today' => 0,
            'total_revenue_month' => 0,
            'total_revenue_all' => 0,
            
            // Total Clicks
            'total_clicks' => 0,
            
            // Total API Calls
            'total_api_calls' => 0,
        ];
        
        if ($qris) {
            // Transactions Today
            $stats['total_transactions_today'] = Transaction::where('qris_id', $qris->qris_id)
                ->whereDate('created_at', today())
                ->count();
            
            // Transactions Yesterday
            $stats['total_transactions_yesterday'] = Transaction::where('qris_id', $qris->qris_id)
                ->whereDate('created_at', today()->subDay())
                ->count();
            
            // Total Transactions All Time
            $stats['total_transactions_all'] = Transaction::where('qris_id', $qris->qris_id)->count();
            
            // Revenue Today
            $stats['total_revenue_today'] = Transaction::where('qris_id', $qris->qris_id)
                ->whereDate('created_at', today())
                ->sum('amount');
            
            // Revenue This Month
            $stats['total_revenue_month'] = Transaction::where('qris_id', $qris->qris_id)
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->sum('amount');
            
            // Total Revenue All Time
            $stats['total_revenue_all'] = Transaction::where('qris_id', $qris->qris_id)->sum('amount');
            
            // Total Clicks
            $stats['total_clicks'] = Transaction::where('qris_id', $qris->qris_id)->sum('total_click');
        }
        
        // Total API Calls
        $stats['total_api_calls'] = ApiKey::where('user_id', $user->user_id)->sum('total_call');
        
        // Calculate percentage changes
        $stats['transactions_change'] = $this->calculatePercentageChange(
            $stats['total_transactions_yesterday'],
            $stats['total_transactions_today']
        );
        
        // QRIS Status
        $qrisStatus = [
            'uploaded' => $qris && $qris->img_url ? true : false,
            'has_payload' => $qris && $qris->qr_code ? true : false,
            'name' => $qris->name ?? null,
        ];
        
        // API Keys Count
        $apiKeysCount = ApiKey::where('user_id', $user->user_id)->count();
        
        // Chart Data
        $chartData = [
            'daily' => [
                'labels' => [],
                'data' => []
            ],
            'monthly' => [
                'labels' => [],
                'data' => []
            ]
        ];

        if ($qris) {
            // Daily Data (Last 30 Days)
            $dailyTransactions = Transaction::where('qris_id', $qris->qris_id)
                ->where('created_at', '>=', now()->subDays(30))
                ->select(
                    DB::raw('DATE(created_at) as date'),
                    DB::raw('SUM(amount) as total_amount')
                )
                ->groupBy('date')
                ->orderBy('date')
                ->get();

            $dates = [];
            $amounts = [];
            
            // Fill missing dates with 0
            for ($i = 29; $i >= 0; $i--) {
                $date = now()->subDays($i)->format('Y-m-d');
                $dates[] = now()->subDays($i)->format('d M');
                
                $transaction = $dailyTransactions->firstWhere('date', $date);
                $amounts[] = $transaction ? $transaction->total_amount : 0;
            }
            
            $chartData['daily']['labels'] = $dates;
            $chartData['daily']['data'] = $amounts;

            // Monthly Data (This Year)
            $monthlyTransactions = Transaction::where('qris_id', $qris->qris_id)
                ->whereYear('created_at', now()->year)
                ->select(
                    DB::raw('MONTH(created_at) as month'),
                    DB::raw('SUM(amount) as total_amount')
                )
                ->groupBy('month')
                ->orderBy('month')
                ->get();

            $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
            $monthlyAmounts = array_fill(0, 12, 0);

            foreach ($monthlyTransactions as $transaction) {
                $monthlyAmounts[$transaction->month - 1] = $transaction->total_amount;
            }

            $chartData['monthly']['labels'] = $months;
            $chartData['monthly']['data'] = $monthlyAmounts;
        }
        
        return view('admin.dashboard', compact('stats', 'qrisStatus', 'apiKeysCount', 'chartData'));
    }
    
    private function calculatePercentageChange($old, $new)
    {
        if ($old == 0) {
            return $new > 0 ? 100 : 0;
        }
        
        return round((($new - $old) / $old) * 100, 1);
    }
}
