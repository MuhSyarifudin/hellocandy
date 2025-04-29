<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Tahunan {{ $year }}</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        margin: 20px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    table th,
    table td {
        padding: 8px 12px;
        text-align: left;
        border: 1px solid #ddd;
    }

    table th {
        background-color: #f2f2f2;
    }

    .header {
        text-align: center;
        margin-bottom: 20px;
    }

    .total {
        font-weight: bold;
    }

    .signature {
        text-align: right;
        margin-top: 30px;
    }

    .footer {
        text-align: center;
        margin-top: 40px;
        font-size: 12px;
    }

    /* Company Logo and Name Styling */
    .company-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .company-header img {
        width: 100px;
        /* Adjust logo size */
        height: auto;
    }

    .company-header .company-name {
        font-size: 24px;
        font-weight: bold;
        color: #333;
        text-align: right;
    }
    </style>
</head>

<body>
    <!-- Company Header: Logo and Name -->
    <div class="company-header">
        <!-- Company Logo -->
        <img src="{{ public_path('img/CANDY.png') }}" alt="Candy Craft Florist Decoration Logo">

        <!-- Company Name -->
        <div class="company-name">
            Candy Craft Florist Decoration
        </div>
    </div>

    <div class="header">
        <h2>Laporan Tahunan {{ $year }}</h2>
        <p>Laporan dari Januari hingga Desember {{ $year }}</p>
    </div>

    <!-- Display Total Sales, Expenses, and Net Profit -->
    <table>
        <thead>
            <tr>
                <th>Total Penjualan</th>
                <th>Total Pengeluaran</th>
                <th>Keuntungan Bersih</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Rp {{ number_format($totalSales, 2, ',', '.') }}</td>
                <td>Rp {{ number_format($totalExpenses, 2, ',', '.') }}</td>
                <td>Rp {{ number_format($netProfit, 2, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <h3>Rincian Laporan</h3>
    <table>
        <thead>
            <tr>
                <th>Nama Laporan</th>
                <th>Total Penjualan</th>
                <th>Total Pengeluaran</th>
                <th>Periode Mulai</th>
                <th>Periode Akhir</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($yearlyDetails as $detail)
            <tr>
                <td>{{ $detail->report->report_name }}</td>
                <td>Rp {{ number_format($detail->total_sales, 2, ',', '.') }}</td>
                <td>Rp {{ number_format($detail->total_expenses, 2, ',', '.') }}</td>
                <td>{{ \Carbon\Carbon::parse($detail->period_start)->format('d M Y H:i') }}</td>
                <td>{{ \Carbon\Carbon::parse($detail->period_end)->format('d M Y H:i') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Signature Section - Align Right (without line) -->
    <div class="signature">
        <p>Mengetahui,</p>
        <br>
        <!-- Removed signature line -->
        <p>Nama Owner</p>
    </div>

    <!-- Footer - Centered -->
    <div class="footer">
        <p>&copy; {{ date('Y') }} Candy Craft Florist Decoration - All Rights Reserved</p>
    </div>
</body>

</html>
