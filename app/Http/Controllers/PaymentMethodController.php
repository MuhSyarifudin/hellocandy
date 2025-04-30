<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PaymentMethod;

class PaymentMethodController extends Controller
{
    public function index()
    {
        $paymentMethods = PaymentMethod::latest()->paginate(10);
        $role = auth()->user()->role;
        return view('Backend.owner.pembayaran.index', compact('paymentMethods', 'role'));
    }

    /**
     * Show the form for creating a new resource.
     * (Not used because adding is handled via modal in index view.)
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'method_name' => 'required|string|unique:payment_methods,method_name',
            'type' => 'required|string',
        ]);

        PaymentMethod::create([
            'method_name' => $request->method_name,
            'type' => $request->type,
        ]);

        return redirect()->route('payment_methods.index')->with('success', 'Metode pembayaran berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(PaymentMethod $paymentMethod)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PaymentMethod $paymentMethod)
    {
        return view('Backend.owner.pembayaran.edit', compact('paymentMethod'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PaymentMethod $paymentMethod)
    {
        $request->validate([
            'method_name' => 'required|string|unique:payment_methods,method_name,' . $paymentMethod->id,
            'type' => 'required|string',
        ]);

        $paymentMethod->update([
            'method_name' => $request->method_name,
            'type' => $request->type,
        ]);

        return redirect()->route('payment_methods.index')->with('success', 'Metode pembayaran berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PaymentMethod $paymentMethod)
    {
        $paymentMethod->delete();

        return redirect()->route('payment_methods.index')->with('success', 'Metode pembayaran berhasil dihapus!');
    }
}