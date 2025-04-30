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
        $salesDetails = SalesDetail::with('product')->get(); // Ambil data beserta relasi ke produk
        $today = today();
        $currentWeek = $today->format('W'); // Ambil minggu ke-berapa dari tahun ini
        $currentMonth = $today->format('n'); // Ambil bulan saat ini
        $currentYear = $today->format('Y'); // Ambil tahun saat ini


        // Total penjualan dan pengeluaran minggu ini
        $weekSales = Sale::whereYear('created_at', $currentYear)
            ->whereMonth('created_at', $currentMonth)
            ->whereRaw('WEEK(created_at, 1) = ?', [$currentWeek])
            ->sum('total_amount');

        $weekExpenses = Expense::whereYear('created_at', $currentYear)
            ->whereMonth('created_at', $currentMonth)
            ->whereRaw('WEEK(created_at, 1) = ?', [$currentWeek])
            ->sum('amount');

        // Total hari ini
        $today_money = Sale::whereDate('created_at', $today)->sum('total_amount');

        // Total pengeluaran
        $expenses = Expense::sum('amount');
        // Total pengguna
        $users = User::count();

        // Total penjualan dan pengeluaran sepanjang bulan ini
        $sales = Sale::whereYear('created_at', $currentYear)
            ->whereMonth('created_at', $currentMonth)
            ->sum('total_amount');

        $expenses = Expense::whereYear('created_at', $currentYear)
            ->whereMonth('created_at', $currentMonth)
            ->sum('amount');

        // Mengambil total bulan lalu
        $lastMonth = $today->copy()->subMonth();
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
        $recentOrders = Sale::with(['user','partner', 'paymentMethod'])
            ->orderBy('date', 'desc')
            ->take(3)
            ->get()
            ->map(function ($order) {
                $order->formatted_date = \Carbon\Carbon::parse($order->date)->format('d M Y');
                return $order;
            });


        // Ambil data penjualan per minggu bulan ini untuk grafik
        $salesPerWeek = Sale::selectRaw('WEEK(created_at, 1) as week, SUM(total_amount) as total_revenue')
            ->whereYear('created_at', $currentYear)
            ->whereMonth('created_at', $currentMonth)
            ->groupBy('week')
            ->orderBy('week')
            ->get();

        // Ambil data pengeluaran per minggu bulan ini untuk grafik
        $expensesPerWeek = Expense::selectRaw('WEEK(created_at, 1) as week, SUM(amount) as total_expense')
            ->whereYear('created_at', $currentYear)
            ->whereMonth('created_at', $currentMonth)
            ->groupBy('week')
            ->orderBy('week')
            ->get();


        // Persiapkan data untuk grafik
        $salesLabels = $salesPerWeek->pluck('week')->toArray();
        $salesData = $salesPerWeek->pluck('total_revenue')->toArray();
        $expenseLabels = $expensesPerWeek->pluck('week')->toArray();
        $expenseData = $expensesPerWeek->pluck('total_expense')->toArray();

        // Kirim data ke view
        $data = [
            'today_money' => $today_money,
            'expenses' => $expenses,
            'users' => $users,
            'sales' => $sales,
            'week_sales' => $weekSales, // Data penjualan minggu ini
            'week_expenses' => $weekExpenses, // Data pengeluaran minggu ini
            'expenses_change' => $expenses_change,
            'sales_change' => $sales_change,
            'sales_details' => $salesDetails,
            'recentOrders' => $recentOrders,
            'sales_labels' => $salesLabels,
            'sales_data' => $salesData,
            'expense_labels' => $expenseLabels,
            'expense_data' => $expenseData,
            'current_week' => $currentWeek,
            'current_month' => $currentMonth,
            'current_year' => $currentYear,
            'money_change' => null,
            'users_change' => null

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

    public function renderRevenueChart(Request $request)
    {
        $labels = json_decode($request->input('labels'));
        $data = json_decode($request->input('data'));
        $month = $request->input('month'); // Mendapatkan bulan
        $year = $request->input('year');   // Mendapatkan tahun

        // Buat gambar grafik pendapatan dengan GD
        return $this->renderChart($labels, $data, "Tren Pendapatan", $month, $year);
    }

    public function renderExpenseChart(Request $request)
    {
        $labels = json_decode($request->input('labels'));
        $data = json_decode($request->input('data'));
        $month = $request->input('month'); // Mendapatkan bulan
        $year = $request->input('year');   // Mendapatkan tahun

        // Buat gambar grafik pengeluaran dengan GD
        return $this->renderChart($labels, $data, "Tren Pengeluaran", $month, $year);
    }

    private function renderChart($labels, $data, $title, $month, $year)
    {
        // Dimensi gambar
        $width = 700;
        $height = 550;

        // Membuat gambar
        $image = imagecreate($width, $height);

        // Menentukan warna
        $backgroundColor = imagecolorallocate($image, 255, 255, 255);
        $barColor = imagecolorallocate($image, 233, 30, 99);
        $textColor = imagecolorallocate($image, 0, 0, 0);
        $titleColor = imagecolorallocate($image, 0, 0, 0);
        $lineColor = imagecolorallocate($image, 200, 200, 200);
        $trendLineColor = imagecolorallocate($image, 184, 134, 11); // Gold agak gelap

        // Mengisi gambar dengan warna latar belakang
        imagefill($image, 0, 0, $backgroundColor);

        // Menampilkan judul grafik
        imagestring($image, 5, ($width / 2) - (strlen($title) * 3), 10, $title, $titleColor);

        // Menampilkan keterangan bulan dan tahun
        $monthYearText = "Periode: $month $year";
        imagestring($image, 4, ($width / 2) - (strlen($monthYearText) * 3), 30, $monthYearText, $titleColor);

        // Menampilkan total pendapatan/pengeluaran
        $total = array_sum($data);
        $totalText = "Total: Rp " . number_format($total, 0, ',', '.');
        imagestring($image, 4, ($width / 2) - (strlen($totalText) * 3), 50, $totalText, $titleColor);

        // Menggambar sumbu X dan Y
        $leftPadding = 80;
        $bottomPadding = 100;
        imageline($image, $leftPadding, 80, $leftPadding, $height - $bottomPadding, $textColor); // Sumbu Y
        imageline($image, $leftPadding, $height - $bottomPadding, $width - 50, $height - $bottomPadding, $textColor); // Sumbu X

        // Menampilkan label sumbu X
        imagestring($image, 4, $width / 2 - 30, $height - 70, "Periode Minggu", $textColor);

        // Menampilkan label sumbu Y dengan posisi lebih jauh dari angka
        imagestringup($image, 4, 40, $height / 2 + 10, "Jumlah", $textColor);

        // Atur ukuran batang dan jaraknya lebih proporsional
        $barStartX = $leftPadding + 50;
        $barWidth = 80;
        $spacing = 100;
        $maxValue = max($data) ?: 1; // Hindari pembagian nol

        // Menampilkan label kategori (Minggu 1 - Minggu 4)
        foreach ($labels as $index => $label) {
            $xPos = $barStartX + ($index * $spacing);
            imagestring($image, 4, $xPos + 10, $height - 90, "Minggu " . ($index + 1), $textColor);
        }

        // Array untuk menyimpan titik atas batang
        $topPoints = [];

        // Menambahkan batang grafik
        foreach ($data as $index => $value) {
            $x1 = $barStartX + ($index * $spacing);
            $y1 = $height - $bottomPadding - ($value / $maxValue) * 300;
            $x2 = $x1 + $barWidth;
            $y2 = $height - $bottomPadding;

            // Menggambar batang
            imagefilledrectangle($image, $x1, $y1, $x2, $y2, $barColor);

            // Menampilkan nilai di atas batang
            imagestring($image, 4, $x1 + 20, $y1 - 20, number_format($value), $textColor);

            // Simpan titik atas batang
            $topPoints[] = [$x1 + ($barWidth / 2), $y1];
        }

        // Menampilkan angka pada sumbu Y dengan lebih banyak ruang dari teks "Jumlah"
        for ($i = 1; $i <= 4; $i++) {
            $yPos = $height - $bottomPadding - ($i * 75);
            imagestring($image, 4, 50, $yPos - 10, number_format($i * ($maxValue / 4)), $textColor);

            // Garis horizontal pembantu
            imageline($image, $leftPadding, $yPos, $width - 50, $yPos, $lineColor);
        }

        // Menghubungkan titik atas batang dengan garis tren warna gold agak gelap
        for ($i = 0; $i < count($topPoints) - 1; $i++) {
            imageline(
                $image,
                $topPoints[$i][0],
                $topPoints[$i][1], // Titik awal
                $topPoints[$i + 1][0],
                $topPoints[$i + 1][1], // Titik akhir
                $trendLineColor
            );
        }

        // Menampilkan gambar
        header('Content-Type: image/png');
        imagepng($image);
        imagedestroy($image);
    }
}