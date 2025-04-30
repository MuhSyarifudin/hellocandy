@extends('Backend.main')

@section('title', 'Cetak Nota Pesanan')
@section('page', 'Cetak Nota Pesanan')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <!-- Bagian Header untuk Logo, Alamat, Barcode, dan Telepon -->
                    <div class="header-info">
                        <!-- Kiri: Logo, Alamat, Nomor Telepon, Sosial Media -->
                        <div class="left-info">

                            <div>
                                <img src="{{ asset('images/logo.png') }}" alt="Candy Logo" style="width: 200px;">
                                <p><i class="fas fa-map-marker-alt"></i> Jl. Kepiting No. 08 C, Banyuwangi</p>
                                <p><i class="fas fa-phone-alt"></i> 0853 3444 7310</p>
                                <p><i class="fab fa-instagram"></i> candycarft.bwi</p>
                            </div>
                        </div>

                        <!-- Barcode: Scan Me -->
                        <div class="barcode">
                            <img src="https://api.qrserver.com/v1/create-qr-code/?data={{ url('your-website-link') }}&size=100x100"
                                alt="Scan me for website">
                            <p><strong>Scan Me</strong></p>
                        </div>

                        <!-- Kanan: Nama Pelanggan, Status Order -->
                        <div class="right-info mt-3">
                            <p><strong>Nama Pelanggan:</strong> {{ $order->partner->name ?? 'N/A' }}</p>
                            <p><strong>Status Order:</strong>
                                <input type="checkbox" {{ $order->status == 'picked_up' ? 'checked' : '' }}>
                                Diambil
                                <input type="checkbox" {{ $order->status == 'shipped' ? 'checked' : '' }}>
                                Dikirim
                            </p>
                            <p><strong>Tanggal Pengambilan/Pengiriman:</strong> <span
                                    id="orderDate">{{ $order->delivery_date ?? '' }}</span></p>
                            <p><strong>Pukul:</strong> <span id="orderTime">{{ $order->delivery_time ?? '' }}</span></p>
                            <p><strong>Nama Penerima:</strong> {{ auth()->user()->username }}</p>
                        </div>
                    </div>

                    <!-- Tabel Pesanan -->
                    <div class="table-responsive">
                        <table class="table table-bordered mt-4 table-custom">
                            <thead>
                                <tr>
                                    <th>Nama Produk</th>
                                    <th>Harga</th>
                                    <th>Jumlah</th>
                                    <th>Total Harga</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->products as $product)
                                <tr>
                                    <td>{{ $product->product_name }}</td>
                                    <td>Rp {{ number_format($product->pivot->price, 2, ',', '.') }}</td>
                                    <td>{{ $product->pivot->quantity }} Qty</td>
                                    <td>Rp
                                        {{ number_format($product->pivot->price * $product->pivot->quantity, 2, ',', '.') }}
                                    </td>
                                </tr>
                                @endforeach
                                <tr>
                                    <td colspan="3" class="text-right"><strong>Total Harga</strong></td>
                                    <td><strong>Rp {{ number_format($order->products->sum(function($product) {
                    return $product->pivot->price * $product->pivot->quantity;
                }), 2, ',', '.') }}</strong></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>


                    <!-- Pembayaran dan Syarat Ketentuan -->
                    <div class="payment-and-terms">
                        <div class="payment-info">
                            <h5>Pembayaran:</h5>
                            <ul class="terms-list">
                                <li>
                                    <input type="checkbox" {{ $order->payment_status == 'full' ? 'checked' : '' }}>
                                    Pembayaran Lunas 100%
                                </li>

                                <!-- Cek jika metode pembayaran adalah cash -->
                                <li>
                                    <input type="checkbox"
                                        {{ $order->guestOrderPartners->firstWhere('paymentMethods_id', 1) ? 'checked' : '' }}>
                                    Tunai
                                </li>

                                <!-- Cek jika metode pembayaran adalah QRIS/Debit/Transfer -->
                                <li>
                                    <input type="checkbox"
                                        {{ $order->guestOrderPartners->firstWhere('paymentMethods_id', 2) ? 'checked' : '' }}>
                                    QRIS/Debit/Transfer
                                </li>

                                <!-- Cek jika pembayaran DP -->
                                <li>
                                    <input type="checkbox" {{ $order->payment_status == 'dp' ? 'checked' : '' }}>
                                    DP (50%)
                                </li>
                            </ul>
                        </div>
                        <div class="terms-info">
                            <h6>Syarat dan Ketentuan:</h6>
                            <ul class="terms-list">
                                <li>Pemesanan produk wajib DP 50%</li>
                                <li>Pemesanan Money Bouquet H-1</li>
                                <li>Pemesanan Instant Bouquet warna/wrapping menyesuaikan stok persediaan</li>
                                <li>Pengambilan wajib menunjukkan nota ini</li>
                                <li>Pembatalan sepihak tidak ada pengembalian dana (hangus)</li>
                            </ul>
                        </div>
                    </div>

                    <!-- No.Rek dan Pesan Terima Kasih -->
                    <div class="thank-you mb-3"
                        style="  padding: 20px; border-radius: 10px; text-align: center; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);">
                        <!-- Informasi Bank -->
                        <div class="bank-info" style="margin-bottom: 20px;">
                            <!-- Logo Bank -->
                            <img src="{{ asset('/images/logo-bca.png') }}" alt="Logo Bank BCA"
                                style="width: 100px; margin-bottom: 10px;">
                            <p style="font-size: 1rem; margin: 0;">
                                <strong>No.Rek :</strong> <span style="font-weight: bold;">BCA 1800 948 254</span>
                            </p>
                            <p style="font-size: 1rem; margin: 0;">
                                <strong>A/N :</strong> <span style="font-weight: bold;">Nurti Oktavia Wulandarsih</span>
                            </p>
                        </div>

                        <!-- Pesan Terima Kasih -->
                        <div class="thank-you-message" style="font-size: 1.2rem; font-weight: bold;">
                            <p>Terima kasih sudah memilih Candy menjadi teman berbagi.</p>
                            <p>Sehat-sehat, lancar rezeki & dimudahkan semuanya! <span class="emoji"
                                    style="font-size: 1.5rem;">❤️</span></p>
                        </div>
                    </div>


                    <div class="text-center no-print">
                        <!-- Tombol untuk mencetak nota dan kembali ke daftar pesanan -->
                        <button class="btn btn-success" onclick="window.print()">Cetak Nota</button>
                        <a href="{{ route('guest_orders.index') }}" class="btn btn-primary">Kembali ke Daftar
                            Pesanan</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
/* Mode Cetak */
@media print {
    @page {
        size: auto;
        /* Menyesuaikan dengan konten */
        margin: 0;
        /* Hilangkan margin halaman */
    }

    body {
        margin: 0;
        padding: 0;
        font-size: 12px;
        overflow-y: visible !important;
        /* Menghindari pemotongan konten */
    }

    .card {
        border: none;
        box-shadow: none;
    }

    .no-print {
        display: none;
        /* Sembunyikan elemen non-cetak */
    }

    .container {
        display: block;
        overflow-y: scroll !important;
        /* Aktifkan scroll jika halaman lebih panjang */
        width: 100%;
    }

    .table-custom {
        width: 100%;
        table-layout: auto;
        border-collapse: collapse;
    }

    .table-custom th,
    .table-custom td {
        padding: 5px;
        font-size: 10px;
    }

    img {
        max-width: 100%;
        height: auto;
    }

    /* Hindari elemen terpotong */
    * {
        page-break-inside: avoid;
        page-break-before: auto;
        page-break-after: auto;
    }

    /* Jika tabel lebih lebar dari halaman, aktifkan horizontal scrolling */
    .table-responsive {
        overflow-x: auto;
    }
}


/* Styling untuk logo, barcode dan informasi di atas */
.header-info {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.header-info .left-info {
    display: flex;
    align-items: center;
}

.header-info .left-info img {
    width: 80px;
    margin-right: 15px;
}

.header-info .left-info div {
    font-size: 0.9rem;
}

.header-info .right-info {
    text-align: right;
    font-size: 0.9rem;
    max-width: 40%;
    /* Membatasi lebar */
}

.barcode {
    text-align: center;
    margin: 20px 0;
}

.barcode img {
    width: 70px;
    /* Ukuran barcode yang lebih kecil */
}

.table-custom th,
.table-custom td {
    text-align: left;
    padding: 8px;
    font-size: 0.9rem;
    word-wrap: break-word;
    /* Membungkus kata panjang */
    overflow-wrap: break-word;
    /* Menjaga teks tetap dalam kolom */
    max-width: 100%;
    box-sizing: border-box;
}

/* Memastikan kolom harga dan total harga tidak meluber */
.table-custom td {
    word-break: break-word;
    /* Agar angka panjang di kolom harga tidak meluber */
}

/* Membatasi lebar kolom harga dan total harga */
.table-custom td.price,
.table-custom td.total {
    max-width: 150px;
    word-wrap: normal;
    overflow: hidden;
    text-overflow: ellipsis;
}

/* Styling untuk keseluruhan tabel */
.table-custom {
    width: 100%;
    border-collapse: collapse;
    table-layout: auto;
    /* Mengatur kolom agar tidak terlalu lebar */
    margin-bottom: 20px;
}

/* Responsivitas untuk perangkat kecil */
@media (max-width: 768px) {

    .table-custom th,
    .table-custom td {
        font-size: 0.8rem;
        padding: 6px;
    }

    .table-custom td.price,
    .table-custom td.total {
        max-width: 120px;
        /* Membatasi lebar kolom harga dan total harga */
        overflow-wrap: break-word;
        /* Membungkus teks panjang */
        text-overflow: ellipsis;
        /* Tambahkan titik-titik jika terlalu panjang */
        white-space: nowrap;
        /* Tetap pada satu baris jika memungkinkan */
    }
}

/* Untuk perangkat sangat kecil */
@media (max-width: 480px) {

    .table-custom th,
    .table-custom td {
        font-size: 0.75rem;
        /* Ukuran font lebih kecil */
        padding: 4px;
        /* Kurangi padding */
    }

    .table-custom td.price,
    .table-custom td.total {
        max-width: 80px;
        /* Kurangi lebar untuk kolom kecil */
        white-space: nowrap;
        text-overflow: ellipsis;
        /* Tambahkan ... jika terlalu panjang */
    }

    /* Menjadikan tabel dapat di-scroll pada layar sempit */
    .table-custom {
        overflow-x: auto;
        display: block;
    }
}


/* Styling untuk terms dan ketentuan */
.terms-list {
    font-size: 0.85rem;
    line-height: 1.4;
    margin-bottom: 15px;
}

/* Styling untuk bagian Pembayaran dan Syarat Ketentuan yang sejajar */
.payment-and-terms {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-top: 20px;
}

.payment-info,
.terms-info {
    width: 48%;
}

.payment-info h5,
.terms-info h5 {
    margin-bottom: 10px;
}

.payment-status li {
    margin-bottom: 8px;
}

/* Styling untuk nama pelanggan dan status pembayaran yang sejajar */
.row-info {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 15px;
}

.row-info .customer-info,
.row-info .payment-info {
    width: 48%;
}

.row-info .customer-info p,
.row-info .payment-info p {
    margin: 0;
    font-size: 0.9rem;
}

/* Styling untuk No.Rek dan Terima Kasih */
.thank-you {
    text-align: center;
    font-size: 1rem;
    margin-top: 30px;
}

.thank-you .bank-info {
    margin: 10px 0;
    font-size: 0.9rem;
}

.thank-you .thank-you-message {
    font-size: 1.1rem;
    font-weight: bold;
    margin-top: 10px;
}

.thank-you .emoji {
    font-size: 1.5rem;
}


/* Responsivitas untuk perangkat kecil */
@media (max-width: 768px) {
    .header-info {
        flex-direction: column;
        align-items: flex-start;
    }

    .header-info .left-info,
    .header-info .right-info {
        max-width: 100%;
        text-align: left;
    }

    .payment-and-terms {
        flex-direction: column;
    }

    .payment-info,
    .terms-info {
        width: 100%;
    }

    .table-custom th,
    .table-custom td {
        font-size: 0.8rem;
    }
}

@media (max-width: 480px) {
    .thank-you .thank-you-message {
        font-size: 1rem;
    }

    .thank-you .bank-info p {
        font-size: 0.8rem;
    }
}
</style>

<script>
document.addEventListener("DOMContentLoaded", function() {
    // Fungsi untuk mengubah format tanggal
    function formatDate(date) {
        var d = new Date(date);
        var month = (d.getMonth() + 1).toString().padStart(2, '0');
        var day = d.getDate().toString().padStart(2, '0');
        var year = d.getFullYear();
        return year + '-' + month + '-' + day;
    }

    // Mendapatkan tanggal dan waktu saat ini
    var currentDate = new Date();
    var formattedDate = formatDate(currentDate);
    var formattedTime = currentDate.toTimeString().split(' ')[0]; // Mengambil waktu jam:min:detik

    // Mengupdate elemen tanggal dan waktu pada halaman
    document.getElementById("orderDate").textContent = formattedDate;
    document.getElementById("orderTime").textContent = formattedTime;
});

document.querySelector('.btn-success').addEventListener('click', function() {
    // Menjamin viewport tetap optimal selama cetak
    document.body.style.width = "100%";
    window.print();
});
</script>

@endsection