<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\User;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function index()
    {
        $sales = Sale::with('user')->get();
        $users = User::all(); // Assuming 'user' is the relationship
        return view('Backend.owner.penjualan.index', compact('sales', 'users'));
    }

    public function create()
    {
        $users = User::all(); // Ambil semua pengguna untuk dropdown kasir
        return view('Backend.owner.penjualan.create', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'total_amount' => 'required|numeric',
            'payment_method' => 'required|in:cash,card,e-wallet',
            'user_id' => 'required|exists:users,id',
        ]);


        Sale::create($validated);
        // Menambahkan flash message
        session()->flash('success', 'Penjualan berhasil ditambahkan!');

        return redirect()->route('sales.index');
    }

    public function edit(Sale $sale)
    {
        $users = User::all(); // Ambil semua pengguna untuk dropdown kasir
        return view('Backend.owner.penjualan.edit', compact('sale', 'users'));
    }

    public function update(Request $request, Sale $sale)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'total_amount' => 'required|numeric',
            'payment_method' => 'required|in:cash,card,e-wallet',
            'user_id' => 'required|exists:users,id',
        ]);

        $sale->update($validated);
        return redirect()->route('sales.index')->with('success', 'Sale updated successfully.');
    }

    public function destroy(Sale $sale)
    {
        $sale->delete();
        return redirect()->route('sales.index')->with('success', 'Sale deleted successfully.');
    }
}