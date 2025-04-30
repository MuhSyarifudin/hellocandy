<?php

namespace App\Http\Controllers;

use App\Models\Partner;
use Illuminate\Http\Request;

class PartnerController extends Controller
{
    public function index(Request $request)
    {
        $query = Partner::query();
        // Filter berdasarkan nomor telepon
        if ($request->filled('search')) {
            $query->where('phone', 'like', '%' . $request->search . '%');
        }

        // Filter berdasarkan tipe customer
        if ($request->filled('filter') && $request->filter === 'customer') {
            $query->where('type', 'customer');
        }

        $partners = $query->paginate(10)->appends($request->query()); // Menjaga query parameter pada pagination
        return view('Backend.owner.partner.index', compact('partners'));
    }

    public function create()
    {
        return view('Backend.owner.partner.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'type' => 'required|in:supplier,customer',
        ]);

        Partner::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'type' => $request->type,
        ]);

        return redirect()->route('partners.index')->with('success', 'Mitra berhasil ditambahkan.');
    }
    public function show($id)
    {
        $partner = Partner::findOrFail($id);
        return view('Backend.owner.partner.show', compact('partner'));
    }

    public function edit($id)
    {
        $partner = Partner::findOrFail($id);
        return view('Backend.owner.partner.edit', compact('partner'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'type' => 'required|in:supplier,customer',
        ]);

        $partner = Partner::findOrFail($id);
        $partner->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'type' => $request->type,
        ]);

        return redirect()->route('partners.index')->with('success', 'Mitra berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $partner = Partner::findOrFail($id);
        $partner->delete();

        return redirect()->route('partners.index')->with('success', 'Mitra berhasil dihapus.');
    }
}
