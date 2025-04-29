@extends('Backend.main')

@section('title', 'Detail Laporan Bulanan')
@section('page', 'Detail Laporan Bulanan')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                    <h6 class="text-white text-capitalize ps-3">Detail: {{ $report->report_name }}
                    </h6>
                </div>
            </div>
            <div class="card-body px-4 pb-2">
                <div class="row mb-3">
                    <div class="col-lg-6">
                        <strong>Nama Laporan:</strong> <br>
                        <span class="text-muted">{{ $report->report_name }}</span>
                    </div>
                    <div class="col-lg-6">
                        <strong>Status:</strong> <br>
                        <span class="badge
                        @if($report->status == 'draft') bg-warning
                        @elseif($report->status == 'diterbitkan') bg-success
                        @elseif($report->status == 'arsip') bg-danger @endif">
                            {{ ucfirst($report->status) }}
                        </span>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-lg-6">
                        <strong>Tanggal Laporan:</strong> <br>
                        <span
                            class="text-muted">{{ \Carbon\Carbon::parse($report->report_date)->format('d M Y, H:i') }}</span>
                    </div>
                    <div class="col-lg-6">
                        <strong>Dibuat Oleh:</strong> <br>
                        <span class="text-muted">{{ $report->user->nama ?? 'Tidak Diketahui' }}</span>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-lg-12">
                        <strong>Catatan:</strong> <br>
                        <p class="text-muted">{{ $report->note ?: 'Tidak ada catatan' }}</p>
                    </div>
                </div>

                <!-- Tabel untuk detail laporan -->
                <div class="table-responsive mb-4">
                    <h5>Detail Laporan</h5>
                    <table class="table table-hover table-bordered align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Minggu
                                    Ke
                                </th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Total
                                    Penjualan</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Total
                                    Pengeluaran</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Periode
                                    Mulai</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Periode
                                    Akhir</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($sameNameReports->isNotEmpty())
                            @foreach($sameNameReports as $sameNameReport)
                            @foreach($sameNameReport->weeklyReports as $weeklyReport)
                            <!-- Assuming weeklyReports relationship -->
                            <tr>
                                <td><span class="text-xs font-weight-bold">{{ $weeklyReport->week_number }}</span></td>
                                <td><span class="text-xs font-weight-bold">Rp
                                        {{ number_format($weeklyReport->total_sales, 2, ',', '.') }}</span></td>
                                <td><span class="text-xs font-weight-bold">Rp
                                        {{ number_format($weeklyReport->total_expenses, 2, ',', '.') }}</span></td>
                                <td><span
                                        class="text-xs font-weight-bold">{{ \Carbon\Carbon::parse($weeklyReport->start_date)->format('d M Y') }}</span>
                                </td>
                                <td><span
                                        class="text-xs font-weight-bold">{{ \Carbon\Carbon::parse($weeklyReport->end_date)->format('d M Y') }}</span>
                                </td>
                            </tr>
                            @endforeach
                            @endforeach
                            @else
                            <tr>
                                <td colspan="5" class="text-center text-muted">Tidak ada laporan lain dengan nama yang
                                    sama.</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>


                @php
                $totalNetProfit = 0;
                @endphp

                <!-- Section for Net Profit Summary -->
                <div class="mb-4">
                    <h5 class="font-weight-bold">Keuntungan Bersih</h5>
                    @if($sameNameReports->isNotEmpty())
                    <div class="table-responsive mb-4">
                        <table class="table table-hover table-bordered align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Minggu Ke</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Keuntungan Bersih</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($sameNameReports as $sameNameReport)
                                @foreach($sameNameReport->weeklyReports as $weeklyReport)
                                @php
                                // Calculate Net Profit for each weekly report
                                $netProfit = $weeklyReport->total_sales - $weeklyReport->total_expenses;
                                $totalNetProfit += $netProfit; // Accumulate total net profit
                                @endphp
                                <tr>
                                    <td><span class="text-xs font-weight-bold">Minggu Ke
                                            {{ $weeklyReport->week_number }}</span></td>
                                    <td><span class="text-xs font-weight-bold">Rp
                                            {{ number_format($netProfit, 2, ',', '.') }}</span></td>
                                </tr>
                                @endforeach
                                @endforeach
                                <tr>
                                    <td class="font-weight-bold text-right">Total Keuntungan Bersih:</td>
                                    <td class="font-weight-bold">Rp {{ number_format($totalNetProfit, 2, ',', '.') }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="text-center text-muted">Tidak ada laporan lain dengan nama yang sama.</div>
                    @endif
                </div>

            </div>

            <div class="text-center">
                <a href="javascript:void(0);" class="btn btn-success" title="Cetak Excel" onclick="exportToExcel()">
                    <i class="fas fa-file-excel"></i> Export to Excel
                </a>
                <a href="javascript:void(0);" class="btn btn-danger" title="Cetak PDF" onclick="exportToPDF()">
                    <i class="fas fa-file-pdf"></i> Export to PDF
                </a>
                <a href="{{ route('daily-reports.index') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </div>
    </div>
</div>
</div>

<!-- Script untuk Ekspor Excel -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
<!-- Script untuk Ekspor PDF -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>



<script>
function exportToExcel() {
    // Mendapatkan elemen tabel
    var table = document.querySelector("table");

    // Mengecek apakah tabel ditemukan
    if (!table) {
        alert("Tabel tidak ditemukan, silakan coba lagi!");
        return;
    }

    // Mengonversi tabel HTML menjadi worksheet Excel
    var workbook = XLSX.utils.table_to_book(table, {
        sheet: "Detail Laporan"
    });

    // Ekspor workbook ke file Excel
    XLSX.writeFile(workbook, "detail_laporan_bulanan.xlsx");
}

function exportToPDF() {
    const element = document.getElementById("report-content");

    // Menggunakan html2canvas untuk menangkap elemen dan menghasilkan gambar
    html2canvas(element, {
        scale: 2
    }).then((canvas) => {
        const imgData = canvas.toDataURL("image/png");
        const pdf = new jsPDF("p", "mm", "a4");

        const imgWidth = 190; // Lebar gambar dalam PDF
        const pageHeight = pdf.internal.pageSize.height; // Tinggi halaman PDF
        const imgHeight = (canvas.height * imgWidth) / canvas.width; // Tinggi gambar proporsional
        let heightLeft = imgHeight;

        let position = 0;

        // Menambahkan gambar ke PDF
        pdf.addImage(imgData, "PNG", 10, position, imgWidth, imgHeight);
        heightLeft -= pageHeight;

        // Jika gambar lebih tinggi dari halaman, tambah halaman baru
        while (heightLeft >= 0) {
            position = heightLeft - imgHeight;
            pdf.addPage();
            pdf.addImage(imgData, "PNG", 10, position, imgWidth, imgHeight);
            heightLeft -= pageHeight;
        }

        pdf.save("detail_laporan_bulanan.pdf");
    }).catch((error) => {
        console.error("Error exporting to PDF:", error);
        alert("Terjadi kesalahan saat mengekspor PDF. Silakan coba lagi.");
    });
}
</script>






@endsection