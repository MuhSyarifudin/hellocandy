<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Report;
use App\Models\ReportDetail;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ReportDetailController extends Controller
{
    public function index(Request $request)
    {
        // Get the selected year from the request, or default to the current year
        $year = $request->input('year', date('Y'));

        // Get all reports for the specified year
        $yearlyDetails = ReportDetail::whereYear('period_start', $year)
            ->whereYear('period_end', $year)
            ->get();

        // Calculate total sales, total expenses, and net profit for the year
        $totalSales = $yearlyDetails->sum('total_sales');
        $totalExpenses = $yearlyDetails->sum('total_expenses');
        $netProfit = $totalSales - $totalExpenses;

        // Get a list of available years for the dropdown
        $availableYears = ReportDetail::selectRaw('YEAR(period_start) as year')
            ->distinct()
            ->pluck('year');

        // Mendapatkan daftar tahun yang tersedia untuk laporan
        $availableYears = Report::selectRaw('YEAR(report_date) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');

        return view('Backend.owner.laporan-lengkap.index', compact('year', 'totalSales', 'totalExpenses', 'netProfit', 'availableYears'));
    }

    public function create()
    {
        return view('Backend.report-details.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'report_id' => 'required|exists:reports,id',
            'total_sales' => 'required|numeric',
            'total_expenses' => 'required|numeric',
            'period_start' => 'required|date',
            'period_end' => 'required|date',
        ]);

        ReportDetail::create($request->all());
        return redirect()->route('reports.index')->with('success', 'Detail laporan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $reportDetail = ReportDetail::findOrFail($id);
        return view('Backend.owner.laporan-lengkap.edit', compact('reportDetail'));
    }

    public function update(Request $request, $id)
    {
        // Validasi input dari form
        $request->validate([
            'report_id' => 'required|numeric',
            'total_sales' => 'required|numeric',
            'total_expenses' => 'required|numeric',
            'period_start' => 'required|date',
            'period_end' => 'required|date|after_or_equal:period_start',
        ]);

        // Mengambil data laporan dari database berdasarkan ID
        $reportDetail = ReportDetail::findOrFail($id);

        // Mengupdate data laporan
        $reportDetail->report_id = $request->input('report_id');
        $reportDetail->total_sales = $request->input('total_sales');
        $reportDetail->total_expenses = $request->input('total_expenses');
        $reportDetail->period_start = $request->input('period_start');
        $reportDetail->period_end = $request->input('period_end');

        // Simpan perubahan ke database
        $reportDetail->save();

        // Redirect ke halaman index atau halaman detail dengan pesan sukses
        return redirect()->route('reports.index')->with('success', 'Detail laporan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        // Mengambil data laporan berdasarkan ID
        $reportDetail = ReportDetail::findOrFail($id);

        // Menghapus data laporan dari database
        $reportDetail->delete();

        // Redirect ke halaman index atau halaman daftar dengan pesan sukses
        return redirect()->route('reports.index')->with('success', 'Detail laporan berhasil dihapus.');
    }

    public function generatePdf($year)
    {
        // Get all report details for the given year
        $yearlyDetails = ReportDetail::whereYear('period_start', $year)
            ->whereYear('period_end', $year)
            ->get();

        // Calculate total sales, total expenses, and net profit for the year
        $totalSales = $yearlyDetails->sum('total_sales');
        $totalExpenses = $yearlyDetails->sum('total_expenses');
        $netProfit = $totalSales - $totalExpenses;

        // Load the Blade view to generate the PDF
        $pdf = Pdf::loadView('Backend.owner.laporan-lengkap.pdf', [
            'year' => $year,
            'totalSales' => $totalSales,
            'totalExpenses' => $totalExpenses,
            'netProfit' => $netProfit,
            'yearlyDetails' => $yearlyDetails,
        ]);

        // Return the PDF file to download
        return $pdf->download('laporan_tahunan_' . $year . '.pdf');
    }
}