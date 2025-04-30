<?php

namespace App\Http\Controllers;

use Storage;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->get(); // Mengambil semua produk beserta kategori
        $categories = Category::all();
        // Peran pengguna login (assume kolom role pada tabel users)
        $role = auth()->user()->role;
        return view('Backend.owner.produk.index', compact('products', 'categories', 'role'));
    }

    /**
     * Menampilkan form untuk membuat produk baru.
     */
    public function create()
    {
        $categories = Category::all(); // Mengambil semua kategori untuk pilihan
        return view('Backend.products.create', compact('categories'));
    }

    /**
     * Menyimpan produk baru ke dalam database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric',
            'purchase_price' => 'required|numeric|min:0',
            'stock' => 'required|integer',
            'unit' => 'required|string|in:pcs,set,box,tangkai',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validasi gambar
        ]);

        // Proses unggah file gambar
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public'); // Menyimpan di disk public
        }

        // Menyimpan data produk ke database
        Product::create([
            'product_name' => $request->product_name,
            'category_id' => $request->category_id,
            'price' => $request->price,
            'purchase_price' => $request->purchase_price,
            'stock' => $request->stock,
            'unit' => $request->unit,
            'description' => $request->description,
            'image' => $imagePath,
        ]);

        return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function show(Product $product)
    {
        return view('Backend.owner.produk.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $categories = Category::all(); // Mengambil semua kategori untuk pilihan
        return view('Backend.owner.produk.edit', compact('product', 'categories'));
    }

    /**
     * Memperbarui data produk di dalam database.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'product_name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'purchase_price' => 'required|numeric|min:0',
            'unit' => 'required|string|in:pcs,set,box,tangkai',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // Hapus gambar lama dari disk jika ada
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }

            // Simpan gambar baru
            $imagePath = $request->file('image')->store('products', 'public');
            $product->image = $imagePath;
        }

        // Update atribut lainnya
        $product->update([
            'product_name' => $request->product_name,
            'category_id' => $request->category_id,
            'price' => $request->price,
            'purchase_price' => $request->purchase_price,
            'unit' => $request->unit,
            'description' => $request->description,
        ]);

        return redirect()->route('products.index')->with('success', 'Produk berhasil diperbarui dengan perubahan stok.');
    }


    /**
     * Menghapus produk dari database.
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus.');
    }
}