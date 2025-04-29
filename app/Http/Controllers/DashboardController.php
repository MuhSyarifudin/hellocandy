<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\User;
use App\Models\Expense;
use App\Models\SalesDetail;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function Dashboard()
    {

        $salesDetails = SalesDetail::with('product')->get(); // Ambil data beserta relasi ke produk jika ada
        $today = today();
        $lastMonth = $today->copy()->subMonth();

        // Total hari ini
        $today_money = Sale::whereDate('created_at', $today)->sum('total_amount');
        // Total pengeluaran
        $expenses = Expense::sum('amount');
        // Total pengguna
        $users = User::count();
        // Total penjualan
        $sales = Sale::sum('total_amount');

        // Mengambil total bulan lalu
        $last_month_expenses = Expense::whereMonth('created_at', $lastMonth->month)
            ->whereYear('created_at', $lastMonth->year)
            ->sum('amount');

        $last_month_sales = Sale::whereMonth('created_at', $lastMonth->month)
            ->whereYear('created_at', $lastMonth->year)
            ->sum('total_amount');

        // Menghitung perubahan
        $expenses_change = $this->calculatePercentageChange($last_month_expenses, $expenses);
        $sales_change = $this->calculatePercentageChange($last_month_sales, $sales);
        // Mengambil pesanan terbaru
        $recentOrders = Sale::orderBy('created_at', 'desc')->take(5)->get();

        $data = [
            'today_money' => $today_money,
            'expenses' => $expenses,
            'users' => $users,
            'sales' => $sales,
            'money_change' => '+55%', // Contoh perubahan uang
            'users_change' => '+3%', // Contoh perubahan pengguna
            'expenses_change' => $expenses_change,
            'sales_change' => $sales_change,
            'sales_details' => $salesDetails, // Tambahkan sales details ke data
            'recent_orders' => $recentOrders // Tambahkan pesanan terbaru ke data
        ];
        return view('Backend.dashboard', compact('data', 'recentOrders'));
    }


    private function calculatePercentageChange($last, $current)
    {
        if ($last == 0) {
            return $current > 0 ? '+100%' : '0%'; // Menghindari pembagian dengan nol
        }
        $change = (($current - $last) / $last) * 100;
        return number_format($change, 2) . '%';
    }
}