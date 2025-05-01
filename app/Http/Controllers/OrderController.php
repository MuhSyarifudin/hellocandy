<?php

namespace App\Http\Controllers;

use App\Models\Partner;
use App\Models\Product;
use App\Models\Category;
use App\Models\GuestOrder;
use Illuminate\Http\Request;
use App\Models\PaymentMethod;

class OrderController extends Controller
{

    public function index()
    {
        $guestOrders = GuestOrder::with('products','paymentMethod')->latest()->paginate(10);
        $partners = Partner::where('type', 'customer')->get();
        $paymentMethods = PaymentMethod::all();
        // Menampilkan view daftar pesanan tamu
        $role = auth()->user()->role;
        return view('Backend.owner.pemesanan.index', compact('guestOrders',  'partners',  'paymentMethods', 'role'));
    }
    public function create()
    {
        // Ambil semua kategori beserta produk di dalamnya
        $categories = Category::with('products')->get();
        return view('Backend.owner.pemesanan.create', compact('categories'));
    }

    public function store(Request $request)
    {
        // Filter hanya produk dengan jumlah lebih dari 0
        $validProducts = collect($request->products)->filter(function ($product) {
            return isset($product['quantity']) && $product['quantity'] > 0;
        });

        // Pastikan setidaknya ada satu produk yang valid
        if ($validProducts->isEmpty()) {
            return redirect()->back()->withErrors('Minimal satu produk harus dipilih.');
        }

        // Buat pesanan tamu baru
        $guestOrder = GuestOrder::create([
            'order_number' => 'ORD' . strtoupper(uniqid()), // Nomor pesanan unik
            'status' => 'pending',
        ]);

        // Simpan produk ke pesanan dan kurangi stok
        foreach ($validProducts as $product) {
            $dbProduct = Product::find($product['id']);

            // Pastikan stok cukup
            if ($dbProduct->stock < $product['quantity']) {
                return redirect()->back()->withErrors("Stok tidak mencukupi untuk produk {$dbProduct->product_name}.");
            }

            // Tambahkan produk ke pesanan
            $guestOrder->products()->attach($product['id'], [
                'quantity' => $product['quantity'],
                'price' => $dbProduct->price, // Harga produk saat dipesan
            ]);

            // Kurangi stok produk
            $dbProduct->stock -= $product['quantity'];
            $dbProduct->save();
        }

        // Redirect ke halaman daftar pesanan dengan pesan sukses
        return redirect()->route('guest_orders.index')->with('success', 'Pesanan berhasil dibuat dan stok diperbarui.');
    }

    public function show($id)
    {
        // Menampilkan detail pesanan guest
        $order = GuestOrder::with(['products', 'guestOrderPartners.paymentMethod'])->findOrFail($id);
        return view('Backend.owner.pemesanan.show', compact('order'));
    }

    public function edit($id)
{
    $order = GuestOrder::with('products')->findOrFail($id);
    $categories = Category::with('products')->get();
    return view('Backend.owner.pemesanan.edit', compact('order', 'categories'));
}

public function update(Request $request, $id)
{
    $request->validate([
        'products' => 'required|array',
        'products.*.id' => 'required|exists:products,id',
        'products.*.quantity' => 'required|integer|min:0',
    ]);

    $order = GuestOrder::findOrFail($id);

    // Pastikan status pesanan tidak "completed" sebelum memperbarui
    if ($order->status === 'completed') {
        return redirect()->back()->withErrors([
            'status' => 'Pesanan yang sudah selesai tidak dapat diperbarui.',
        ]);
    }

    // Sinkronisasi produk
    $products = [];
    foreach ($request->products as $product) {
        if ($product['quantity'] > 0) {
            $products[$product['id']] = [
                'quantity' => $product['quantity'],
                'price' => Product::find($product['id'])->price,
            ];
        }
    }
    $order->products()->sync($products);

     // Periksa apakah pesanan memenuhi syarat untuk diselesaikan
     $isPaymentComplete = $order->is_payment_complete;
     $isProcessingComplete = $order->is_processing_complete;

     // Jika semua syarat terpenuhi, ubah status menjadi "completed"
     if ($isPaymentComplete && $isProcessingComplete) {
         $order->status = 'completed';
     } else {
         $order->status = 'pending'; // Pastikan tetap "pending" jika syarat belum terpenuhi
     }

     // Simpan perubahan
     $order->save();

    return redirect()->route('guest_orders.index')->with('success', 'Pesanan berhasil diperbarui.');
}

public function printNota($id)
{
    $order = GuestOrder::with('products','guestOrderPartners.paymentMethod')->findOrFail($id);
    return view('Backend.owner.pemesanan.nota', compact('order'));
}

public function updateStatus(Request $request, $id)
{
    // Validasi input
    $request->validate([
        'status' => 'required|in:pending,completed',
    ]);

    // Temukan pesanan dan perbarui statusnya
    $order = GuestOrder::findOrFail($id);
    $order->status = $request->status;
    $order->save();

    // Redirect kembali ke halaman index dengan pesan sukses
    return redirect()->route('guest_orders.index')->with('success', 'Status pesanan berhasil diperbarui.');
}

public function updatePaymentStatus(Request $request, $id)
{
    $order = GuestOrder::findOrFail($id);
    $order->is_payment_complete = $request->input('is_payment_complete');
    $this->updateOrderStatus($order); // Periksa dan perbarui status order
    $order->save();

    return redirect()->route('guest_orders.index')->with('success', 'Status pembayaran berhasil diperbarui.');
}

public function updateProcessingStatus(Request $request, $id)
{
    $order = GuestOrder::findOrFail($id);
    $order->is_processing_complete = $request->input('is_processing_complete');
    $this->updateOrderStatus($order); // Periksa dan perbarui status order
    $order->save();

    return redirect()->route('guest_orders.index')->with('success', 'Status pengerjaan berhasil diperbarui.');
}


private function updateOrderStatus(GuestOrder $order)
{
    if ($order->is_payment_complete && $order->is_processing_complete) {
        $order->status = 'completed';
    } else {
        $order->status = 'pending';
    }
}

public function updatePartner(Request $request, GuestOrder $order)
{
    // Validasi partner_id
    $request->validate([
        'partner_id' => 'required|exists:partners,id',
    ]);

    // Update partner_id pada pesanan
    $order->partner_id = $request->partner_id;
    $order->save();

    // Redirect kembali dengan pesan sukses
    return redirect()->route('guest_orders.index')->with('success', 'Customer berhasil diperbarui');
}

public function updatePaymentMethod(Request $request, $id)
{
    $validated = $request->validate([
        'payment_methods_id' => 'required|exists:payment_methods,id', // Validasi agar ID pembayaran ada dalam tabel payment_methods
    ]);

    $order = GuestOrder::findOrFail($id);
    $order->payment_methods_id = $validated['payment_methods_id'];
    $order->save();

    return redirect()->back()->with('success', 'Payment method updated successfully.');
}


}