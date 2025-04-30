<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Report;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;


class ReportController extends Controller
{
    public function index()
    {
        // Ambil semua data report dengan informasi pengguna yang membuat laporan
        $reports = Report::with('user')->orderBy('report_date', 'desc')->get();
        $users = User::all();

        $reports = $reports->groupBy(function ($item) {
            return $item->report_name . '-' . $item->report_date->format('Y'); // Mengelompokkan berdasarkan nama laporan dan tahun
        })->map(function ($group) {
            return $group->first(); // Ambil hanya satu laporan dari setiap grup
        })->values(); // Kembalikan ke array
        $role = auth()->user()->role;

        // Kembalikan ke view
        return view('Backend.owner.laporan-harian.index', compact('reports', 'users', 'role'));
    }

    public function create()
    {
        // Ambil daftar pengguna untuk ditampilkan di form
        $users = User::all();

        // Kembalikan view untuk membuat laporan baru
        return view('reports.create', compact('users'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'report_date' => 'required|date',
            'report_name' => 'required|string|max:255',
            'report_type' => 'required|string',
            'status' => 'required|string',
            'note' => 'nullable|string',
        ]);

        // Simpan laporan baru
        Report::create([
            'report_date' => $request->report_date,
            'report_name' => $request->report_name,
            'report_type' => $request->report_type,
            'status' => $request->status,
            'note' => $request->note,
            'user_id' => auth()->id(), // assuming you are storing the authenticated user ID
        ]);


        // Redirect kembali ke daftar laporan dan tampilkan pesan sukses
        return redirect()->route('daily-reports.index')->with('success', 'Laporan berhasil ditambahkan.');
    }

    public function show($id)
    {
        $report = Report::with(['user', 'weeklyReports'])->findOrFail($id);

        // Fetch other reports with the same name for detail display
        $sameNameReports = Report::where('report_name', $report->report_name)->get();

        return view('Backend.owner.laporan-harian.show', compact('report', 'sameNameReports'));
    }

    public function edit($id)
    {
        $report = Report::findOrFail($id);
        // Ambil semua pengguna untuk pilihan di form edit
        $users = User::all();

        // Kembalikan view edit laporan dengan data laporan yang dipilih
        return view('Backend.owner.laporan-harian.edit', compact('report', 'users'));
    }

    public function update(Request $request, $id)
    {
        // Validasi input dari form
        $validated = $request->validate([
            'report_name' => 'required|string|max:255',
            'report_date' => 'required|date', // Ensure the date is validated
            'note' => 'nullable|string',
            'status' => 'required|in:draft,diterbitkan,arsip',
        ]);

        // Temukan laporan berdasarkan ID yang diberikan
        $report = Report::findOrFail($id);

        // Perbarui data laporan
        $report->update([
            'report_name' => $validated['report_name'],
            'report_date' => $validated['report_date'], // This will be stored in Y-m-d H:i:s format
            'note' => $validated['note'],
            'status' => $validated['status'], // Simpan status yang diperbarui
        ]);

        // Redirect ke halaman daftar laporan dengan pesan sukses
        return redirect()->route('daily-reports.index')->with('success', 'Laporan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        // Cari laporan berdasarkan ID dan hapus
        $report = Report::findOrFail($id);
        $report->delete();

        // Redirect dengan pesan sukses
        return redirect()->route('daily-reports.index')->with('success', 'Laporan berhasil dihapus.');
    }
}
