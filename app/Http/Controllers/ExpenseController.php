<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\PaymentType;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function index()
    {
        $expenses = Expense::with('paymentType', 'user')->latest()->paginate(10);
        $paymentTypes = PaymentType::all();
        $role = auth()->user()->role;
        return view('Backend.owner.pengeluaran.index', compact('expenses', 'paymentTypes','role')); // Mengirim data ke view
    }

    public function create()
    {
        $paymentTypes = PaymentType::all();
        return view('expenses.create', compact('paymentTypes'));

    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'expense_name' => 'required|string',
            'amount' => 'required|numeric',
            'date' => 'required|date',
            'payment_type_id' => 'required|exists:payment_types,id', // Pastikan payment_type_id valid
            'note' => 'nullable|string|max:500',
        ]);

        // Simpan pengeluaran dengan jenis pembayaran
        Expense::create([
            'expense_name' => $validatedData['expense_name'],
            'amount' => $validatedData['amount'],
            'date' => $validatedData['date'],
            'payment_type_id' => $validatedData['payment_type_id'],
            'note' => $validatedData['note'],
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('expenses.index')->with('success', 'Pengeluaran berhasil disimpan!');
    }


    public function show(Expense $expense)
    {
        // Menampilkan detail pengeluaran tertentu
        return view('expenses.show', compact('expense'));
    }

    public function edit(Expense $expense)
    {
        $paymentTypes = PaymentType::all();
        return view('Backend.owner.pengeluaran.edit', compact('expense', 'paymentTypes'));
    }

    public function update(Request $request, Expense $expense)
    {
        $validatedData = $request->validate([
            'expense_name' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'date' => 'required|date',
            'payment_type_id' => 'required|exists:payment_types,id',  // Validasi untuk jenis pembayaran yang dipilih
            'note' => 'nullable|string|max:500',
        ]);

        // Update pengeluaran dengan data yang telah divalidasi
        $expense->update($validatedData);

        // Redirect ke halaman pengeluaran dengan pesan sukses
        return redirect()->route('expenses.index')->with('success', 'Pengeluaran berhasil diperbarui!');
    }

    public function destroy(Expense $expense)
    {
        // Menghapus pengeluaran dari database
        $expense->delete();

        // Redirect ke halaman daftar pengeluaran dengan pesan sukses
        return redirect()->route('expenses.index')->with('success', 'Pengeluaran berhasil dihapus!');
    }
}