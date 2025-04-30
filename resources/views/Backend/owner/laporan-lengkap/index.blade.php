@extends('Backend.main')

@section('title', 'Manajemen Laporan Tahunan')
@section('page', 'Laporan Tahunan')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div
                    class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3 d-flex justify-content-between">
                    <h6 class="text-white text-capitalize ps-3">Laporan Tahunan ({{ $year }})</h6>

                    <!-- Dropdown for Year Selection -->
                    <form method="GET" action="{{ route('reports.index') }}" class="me-3">
                        <select name="year" class="form-select custom-year-dropdown" onchange="this.form.submit()">
                            @foreach ($availableYears as $availableYear)
                            <option value="{{ $availableYear }}" {{ $availableYear == $year ? 'selected' : '' }}>
                                Tahun {{ $availableYear }}
                            </option>
                            @endforeach
                        </select>
                    </form>
                </div>
            </div>
            <div class="card-body px-0 pb-2">
                @if (session('success'))
                <div class="alert alert-success fade show" role="alert" id="successAlert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif
                <div class="p-3">
                    <!-- Display Period Range -->
                    <p class="text-muted">Laporan dari Januari hingga Desember {{ $year }}</p>
                </div>

                <div class="table-responsive p-3">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th>Total Penjualan</th>
                                <th>Total Pengeluaran</th>
                                <th>Keuntungan Bersih</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <strong>Rp {{ number_format($totalSales, 2, ',', '.') }}</strong>
                                </td>
                                <td>
                                    <strong>Rp {{ number_format($totalExpenses, 2, ',', '.') }}</strong>
                                </td>
                                <td>
                                    <strong>Rp {{ number_format($netProfit, 2, ',', '.') }}</strong>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="text-center">
                        <a href="{{ route('reports.pdf', ['year' => $year]) }}" class="btn btn-danger">
                            <i class="fas fa-print"></i> Cetak PDF
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Custom Styles for the Dropdown -->
<style>
/* Custom style to make the selected dropdown option appear with white background and black text */
.custom-year-dropdown {
    background-color: white !important;
    color: black !important;
    font-weight: bold;
}

/* Additional styling to make sure dropdown opens with expected colors */
.custom-year-dropdown option {
    color: black;
    background-color: white;
}
</style>
@endsection