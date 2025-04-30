<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\SalesDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SalesDetailController extends Controller
{
    public function index(Request $request)
    {
        // Menentukan tahun mulai dari 2000 hingga tahun sekarang
        $currentYear = date('Y');
        $years = collect(range(2000, $currentYear));  // Membuat koleksi tahun dari 2000 sampai tahun sekarang

        // Tahun yang dipilih oleh user (default tahun sekarang)
        $selectedYear = $request->input('year', $currentYear);

        // Ambil data penjualan berdasarkan tahun yang dipilih
        $salesData = DB::table('sales_details')
            ->select('product_id', DB::raw('SUM(quantity) as total_quantity'))
            ->whereYear('created_at', $selectedYear) // Pastikan $selectedYear adalah 2024
            ->groupBy('product_id')
            ->get();

        // Ambil detail produk berdasarkan ID produk
        $products = Product::whereIn('id', $salesData->pluck('product_id'))->get();

        // Gabungkan data produk dengan total penjualan
        $salesData = $salesData->map(function ($item) use ($products) {
            $product = $products->where('id', $item->product_id)->first();
            return [
                'product_name' => $product->product_name ?? 'Tidak Diketahui',
                'total_quantity' => $item->total_quantity,
            ];
        });



        // Menampilkan view dengan data yang sudah disiapkan
        return view('Backend.owner.riwayat-penjualan.index', compact('salesData', 'years', 'selectedYear'));
    }
}
