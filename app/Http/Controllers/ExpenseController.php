<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function index()
    {
        // Mengambil semua data pengeluaran dan memuat halaman index
        $expenses = Expense::with('user')->get(); // Mengambil pengeluaran beserta pengguna yang terkait
        return view('Backend.owner.pengeluaran.index', compact('expenses')); // Mengirim data ke view
    }

    /**
     * Show the form for creating a new resource (CREATE).
     */
    public function create()
    {
        // Mengirim form untuk menambah pengeluaran baru
        return view('expenses.create');
    }

    /**
     * Store a newly created resource in storage (STORE).
     */
    public function store(Request $request)
    {
        // Validasi input dari request
        $request->validate([
            'expense_name' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'date' => 'required|date',
        ]);

        // Menyimpan pengeluaran baru ke database
        Expense::create([
            'expense_name' => $request->expense_name,
            'amount' => $request->amount,
            'date' => $request->date,
            'user_id' => auth()->id(), // Mengambil ID pengguna yang sedang login
        ]);

        // Redirect ke halaman daftar pengeluaran dengan pesan sukses
        return redirect()->route('expenses.index')->with('success', 'Pengeluaran berhasil ditambahkan!');
    }

    /**
     * Display the specified resource (READ SINGLE).
     */
    public function show(Expense $expense)
    {
        // Menampilkan detail pengeluaran tertentu
        return view('expenses.show', compact('expense'));
    }

    /**
     * Show the form for editing the specified resource (EDIT).
     */
    public function edit(Expense $expense)
    {
        // Menampilkan form untuk mengedit pengeluaran tertentu
        return view('Backend.owner.pengeluaran.edit', compact('expense'));
    }

    /**
     * Update the specified resource in storage (UPDATE).
     */
    public function update(Request $request, Expense $expense)
    {
        // Validasi input
        $request->validate([
            'expense_name' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'date' => 'required|date',
        ]);

        // Update pengeluaran di database
        $expense->update($request->all());

        // Redirect ke halaman daftar pengeluaran dengan pesan sukses
        return redirect()->route('expenses.index')->with('success', 'Pengeluaran berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage (DELETE).
     */
    public function destroy(Expense $expense)
    {
        // Menghapus pengeluaran dari database
        $expense->delete();

        // Redirect ke halaman daftar pengeluaran dengan pesan sukses
        return redirect()->route('expenses.index')->with('success', 'Pengeluaran berhasil dihapus!');
    }
}