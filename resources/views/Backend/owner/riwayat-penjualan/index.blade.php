@extends('Backend.main')

@section('title', 'Riwayat Penjualan per Tahun')
@section('page', 'Riwayat Penjualan per Tahun')

@section('content')
<div class="row">
    <div class="col-12">
        <!-- Menampilkan produk terlaris -->
        <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                    <h6 class="text-white text-capitalize ps-3">Riwayat Produk Terlaris Tahun {{ $selectedYear }}</h6>
                </div>
            </div>
            <div class="card-body px-0 pb-2">
                <div class="table-responsive p-3">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Produk</th>
                                <th>Jumlah Total Terjual</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($salesData->isEmpty())
                            <tr>
                                <td colspan="3" class="text-center">Tidak ada data untuk tahun {{ $selectedYear }}.</td>
                            </tr>
                            @else
                            @foreach($salesData as $index => $product)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $product['product_name'] }}</td>
                                <td>{{ $product['total_quantity'] }} Qty</td>
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Menampilkan filter tahun -->
<div class="row mt-4">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header pb-0">
                <h6>Filter Penjualan Berdasarkan Tahun</h6>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('sales-history.index') }}">
                    <div class="form-group">
                        <label for="year">Pilih Tahun:</label>
                        <select name="year" class="form-control">
                            @foreach($years as $year)
                            <option value="{{ $year }}" {{ $year == $selectedYear ? 'selected' : '' }}>
                                {{ $year }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary mt-2">Filter</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection