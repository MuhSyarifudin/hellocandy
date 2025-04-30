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
        $inventories = Inventory::with('product', 'user')->latest()->paginate(10);
        $products = Product::all();
        return view('backend.owner.inventaris.index', compact('inventories', 'products'));
    }

    public function create()
    {
        // Mengambil semua produk untuk digunakan di form pembuatan inventaris
        $products = Product::all();
        return view('backend.owner.inventaris.create', compact('products'));
    }

    public function store(Request $request)
    {
        // Validasi input dari pengguna
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'type' => 'required|in:operasional,non-operasional',
            'quantity_change' => 'required|integer', // Bisa positif atau negatif
            'reason' => 'required|string|max:255',
            'date' => 'required|date',
        ]);

        // Cari produk terkait
        $product = Product::findOrFail($request->product_id);

        // Hitung stok baru
        $newStock = $product->stock + $request->quantity_change;

        // Pastikan stok tidak negatif
        if ($newStock < 0) {
            return redirect()->back()->withErrors(['quantity_change' => 'Stok tidak boleh menjadi negatif!']);
        }

        // Perbarui stok produk
        $product->stock = $newStock;
        $product->save();

        // Simpan data inventaris baru
        Inventory::create([
            'product_id' => $request->product_id,
            'type' => $request->type, // Menyimpan kategori inventaris
            'quantity_change' => $request->quantity_change,
            'reason' => $request->reason,
            'date' => $request->date,
            'user_id' => auth()->id(), // Mendapatkan ID pengguna yang sedang login
        ]);

        return redirect()->route('inventory.index')->with('success', 'Perubahan stok berhasil ditambahkan.');
    }

    public function show(Inventory $inventory)
    {
        // Menampilkan detail dari inventaris tertentu
        return view('backend.inventory.show', compact('inventory'));
    }

    public function edit(Inventory $inventory)
    {
        // Mengambil semua produk untuk digunakan di form edit inventaris
        $products = Product::all();
        return view('backend.owner.inventaris.edit', compact('inventory', 'products'));
    }

    public function update(Request $request, Inventory $inventory)
    {
        // Validasi input dari pengguna
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'type' => 'required|in:operasional,non-operasional', // Validasi kategori inventaris
            'quantity_change' => 'required|integer', // Bisa positif atau negatif
            'reason' => 'required|string|max:255',
            'date' => 'required|date',
        ]);

        // Cari produk terkait
        $product = Product::findOrFail($request->product_id);

        // Hitung selisih perubahan stok
        $stock_difference = $request->quantity_change - $inventory->quantity_change;

        // Perbarui stok produk
        $product->stock += $stock_difference;

        // Pastikan stok tidak negatif
        if ($product->stock < 0) {
            return redirect()->back()->withErrors(['quantity_change' => 'Stok tidak boleh menjadi negatif!']);
        }

        $product->save();

        // Perbarui data inventaris
        $inventory->update([
            'product_id' => $request->product_id,
            'type' => $request->type, // Memperbarui kategori inventaris
            'quantity_change' => $request->quantity_change,
            'reason' => $request->reason,
            'date' => $request->date,
            'user_id' => auth()->id(), // Mendapatkan ID pengguna yang sedang login
        ]);

        return redirect()->route('inventory.index')->with('success', 'Perubahan stok berhasil diperbarui.');
    }

    public function destroy(Inventory $inventory)
    {
        // Menghapus data inventaris
        $inventory->delete();

        return redirect()->route('inventory.index')->with('success', 'Perubahan stok berhasil dihapus.');
    }
}