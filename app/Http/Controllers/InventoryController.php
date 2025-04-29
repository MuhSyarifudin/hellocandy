<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Inventory;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index()
    {
        // Mengambil semua data inventaris dengan relasi produk dan pengguna
        $inventories = Inventory::with('product', 'user')->get();
        $products = Product::all();
        return view('backend.owner.inventaris.index', compact('inventories', 'products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Mengambil semua produk untuk digunakan di form pembuatan inventaris
        $products = Product::all();
        return view('backend.owner.inventaris.create', compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input dari pengguna
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity_change' => 'required|integer',
            'reason' => 'required|string|max:255',
            'date' => 'required|date',
        ]);

        // Menyimpan data inventaris baru
        Inventory::create([
            'product_id' => $request->product_id,
            'quantity_change' => $request->quantity_change,
            'reason' => $request->reason,
            'date' => $request->date,
            'user_id' => auth()->id(), // Mendapatkan ID pengguna yang sedang login
        ]);

        return redirect()->route('inventory.index')->with('success', 'Perubahan stok berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Inventory $inventory)
    {
        // Menampilkan detail dari inventaris tertentu
        return view('backend.inventory.show', compact('inventory'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Inventory $inventory)
    {
        // Mengambil semua produk untuk digunakan di form edit inventaris
        $products = Product::all();
        return view('backend.owner.inventaris.edit', compact('inventory', 'products'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Inventory $inventory)
    {
        // Validasi input dari pengguna
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity_change' => 'required|integer',
            'reason' => 'required|string|max:255',
            'date' => 'required|date',
        ]);

        // Memperbarui data inventaris yang ada
        $inventory->update([
            'product_id' => $request->product_id,
            'quantity_change' => $request->quantity_change,
            'reason' => $request->reason,
            'date' => $request->date,
            'user_id' => auth()->id(), // Mendapatkan ID pengguna yang sedang login
        ]);

        return redirect()->route('inventory.index')->with('success', 'Perubahan stok berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Inventory $inventory)
    {
        // Menghapus data inventaris
        $inventory->delete();

        return redirect()->route('inventory.index')->with('success', 'Perubahan stok berhasil dihapus.');
    }
}