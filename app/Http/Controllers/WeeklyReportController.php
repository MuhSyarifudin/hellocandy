<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\WeeklyReport;
use Illuminate\Http\Request;

class WeeklyReportController extends Controller
{
    public function index()
    {
        $weeklyReports = WeeklyReport::with('report')->latest()->paginate(10);

        // Get the earliest report for each report name
        $reports = Report::select('id', 'report_name')
            ->with('weeklyReports') // Optionally eager load related weekly reports
            ->orderBy('created_at', 'asc') // Ensure reports are ordered by creation date
            ->get()
            ->groupBy('report_name') // Group reports by their name
            ->map(function ($group) {
                return $group->first(); // Select the first (earliest) report from each group
            });
            $role = auth()->user()->role;
        return view('Backend.owner.laporan-mingguan.index', compact('weeklyReports', 'reports','role'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'report_id' => 'required|exists:reports,id',
            'week_number' => 'required|integer|min:1|max:4',
            'total_sales' => 'required|numeric',
            'total_expenses' => 'required|numeric',
        ]);

        WeeklyReport::create([
            'report_id' => $request->report_id,
            'week_number' => $request->week_number,
            'total_sales' => $request->total_sales,
            'total_expenses' => $request->total_expenses,
        ]);

        return redirect()->route('weekly-reports.index')->with('success', 'Laporan Mingguan berhasil ditambahkan.');
    }

    public function show(string $id)
    {
        $weeklyReport = WeeklyReport::with('report')->findOrFail($id);
        return view('Backend.owner.laporan-mingguan.show', compact('weeklyReport'));
    }

    public function edit(string $id)
    {
        $weeklyReport = WeeklyReport::with('report')->findOrFail($id);
        $reports = Report::select('id', 'report_name')
        ->with('weeklyReports') // Optionally eager load related weekly reports
        ->orderBy('created_at', 'asc') // Ensure reports are ordered by creation date
        ->get()
        ->groupBy('report_name') // Group reports by their name
        ->map(function ($group) {
            return $group->first(); // Select the first (earliest) report from each group
        });
        return view('Backend.owner.laporan-mingguan.edit', compact('weeklyReport', 'reports'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'report_id' => 'required|exists:reports,id',
            'week_number' => 'required|integer|min:1|max:4',
            'total_sales' => 'required|numeric',
            'total_expenses' => 'required|numeric',
        ]);

        $weeklyReport = WeeklyReport::findOrFail($id);
        $weeklyReport->update([
            'report_id' => $request->report_id,
            'week_number' => $request->week_number,
            'total_sales' => $request->total_sales,
            'total_expenses' => $request->total_expenses,
        ]);

        return redirect()->route('weekly-reports.index')->with('success', 'Laporan Mingguan berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $weeklyReport = WeeklyReport::findOrFail($id);
        $weeklyReport->delete();

        return redirect()->route('weekly-reports.index')->with('success', 'Laporan Mingguan berhasil dihapus.');
    }
}
