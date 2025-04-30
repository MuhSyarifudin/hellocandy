<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\User;
use App\Models\GuestOrder;
use Illuminate\Http\Request;
use App\Models\PaymentMethod;

class SaleController extends Controller
{
    public function index()
    {
        $sales = Sale::with(['user', 'paymentMethod', 'guestOrders'])->latest()->paginate(10);
        $users = User::all();
        $paymentMethods = PaymentMethod::all();
        $guestOrders = GuestOrder::where('status', 'pending')->whereNull('sale_id')->get(); 
        $role = auth()->user()->role;
        return view('Backend.owner.penjualan.index', compact('sales', 'users', 'paymentMethods','role', 'guestOrders'));
    }

    public function create()
    {
        $users = User::all(); // Ambil semua pengguna untuk dropdown kasir
        $paymentMethods = PaymentMethod::all();
        $guestOrders = GuestOrder::whereNull('sale_id')->get(); // Pesanan tamu yang belum terhubung ke penjualan
        return view('Backend.owner.penjualan.create', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'total_amount' => 'required|numeric',
            'payment_method_id' => 'required|exists:payment_methods,id',
            'user_id' => 'required|exists:users,id',
            'guest_order_id' => 'nullable|exists:guest_orders,id',
        ]);

        // Simpan data penjualan
        $sale = Sale::create([
            'date' => $validated['date'],
            'total_amount' => $validated['total_amount'],
            'payment_method_id' => $validated['payment_method_id'],
            'user_id' => auth()->id(), // Pastikan user yang login
        ]);

        // Jika ada pesanan tamu yang dipilih, hubungkan dengan penjualan ini
        if ($request->guest_order_id) {
            $guestOrder = GuestOrder::find($request->guest_order_id);
            $guestOrder->sale_id = $sale->id;
            $guestOrder->save();
        }

        session()->flash('success', 'Penjualan berhasil ditambahkan!');
        return redirect()->route('sales.index');
    }

    public function edit(Sale $sale)
    {
        $users = User::all();
        $paymentMethods = PaymentMethod::all();
        $guestOrders = GuestOrder::whereNull('sale_id')->orWhere('sale_id', $sale->id)->get();

        return view('Backend.owner.penjualan.edit', compact('sale', 'users', 'paymentMethods', 'guestOrders'));
    }

    public function update(Request $request, Sale $sale)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'total_amount' => 'required|numeric',
            'payment_method_id' => 'required|exists:payment_methods,id',
            'user_id' => 'required|exists:users,id',
            'guest_order_id' => 'nullable|exists:guest_orders,id',
        ]);

        $sale->update($validated);

        // Update pesanan tamu jika ada perubahan
        if ($request->guest_order_id) {
            $guestOrder = GuestOrder::find($request->guest_order_id);
            $guestOrder->sale_id = $sale->id;
            $guestOrder->save();
        }

        return redirect()->route('sales.index')->with('success', 'Penjualan berhasil diperbarui.');
    }

    public function destroy(Sale $sale)
    {
        // Jika ada pesanan tamu terkait, hapus relasi
        GuestOrder::where('sale_id', $sale->id)->update(['sale_id' => null]);

        $sale->delete();
        return redirect()->route('sales.index')->with('success', 'Penjualan berhasil dihapus.');
    }
}