<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Penjualan Mingguan - Cetak</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid #ddd;
        }
        .company-name {
            font-size: 22px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .report-title {
            font-size: 18px;
            margin-bottom: 5px;
        }
        .report-period {
            font-size: 14px;
            color: #666;
        }
        .summary-cards {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .card {
            width: 30%;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            text-align: center;
        }
        .card-title {
            font-size: 14px;
            color: #666;
            margin-bottom: 5px;
        }
        .card-value {
            font-size: 18px;
            font-weight: bold;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .text-right {
            text-align: right;
        }
        .section-title {
            font-size: 16px;
            font-weight: bold;
            margin: 20px 0 10px 0;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            color: #666;
            font-size: 12px;
        }
        .no-data {
            text-align: center;
            color: #666;
            padding: 20px;
            font-style: italic;
        }
        @media print {
            body {
                padding: 0;
                margin: 10mm;
            }
            .no-print {
                display: none;
            }
            .page-break {
                page-break-before: always;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="company-name">POS Meet</div>
        <div class="report-title">Laporan Penjualan Mingguan</div>
        <div class="report-period">{{ date('d M Y', strtotime($weekStart)) }} - {{ date('d M Y', strtotime($weekEnd)) }}</div>
        <div>Laporan Dibuat: {{ date('d M Y H:i') }}</div>
    </div>

    <div class="summary-cards">
        <div class="card">
            <div class="card-title">Total Penjualan</div>
            <div class="card-value">Rp {{ number_format($totalSales, 0, ',', '.') }}</div>
        </div>
        <div class="card">
            <div class="card-title">Jumlah Transaksi</div>
            <div class="card-value">{{ $totalOrders }}</div>
        </div>
        <div class="card">
            <div class="card-title">Item Terjual</div>
            <div class="card-value">{{ $totalItems }}</div>
        </div>
    </div>

    <div class="section-title">Detail Penjualan Harian</div>
    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th class="text-right">Transaksi</th>
                <th class="text-right">Penjualan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($dailySales as $day)
            <tr>
                <td>{{ date('D, d M Y', strtotime($day->date)) }}</td>
                <td class="text-right">{{ $day->order_count }}</td>
                <td class="text-right">Rp {{ number_format($day->total_sales, 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="3" class="no-data">Tidak ada data penjualan untuk periode ini</td>
            </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <th>Total</th>
                <th class="text-right">{{ $totalOrders }}</th>
                <th class="text-right">Rp {{ number_format($totalSales, 0, ',', '.') }}</th>
            </tr>
        </tfoot>
    </table>

    <div class="section-title">Produk Terlaris</div>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Produk</th>
                <th>Kategori</th>
                <th class="text-right">Qty</th>
                <th class="text-right">Total</th>
            </tr>
        </thead>
        <tbody>
            @forelse($topProducts as $index => $product)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $product->product_name }}</td>
                <td>{{ $product->category_name }}</td>
                <td class="text-right">{{ $product->total_qty }}</td>
                <td class="text-right">Rp {{ number_format($product->total_amount, 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="no-data">Tidak ada data produk terlaris</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        © {{ date('Y') }} POS Meet. All rights reserved.<br>
        Laporan ini bersifat rahasia dan hanya untuk penggunaan internal.
    </div>

    <div class="no-print" style="margin-top: 20px; text-align: center;">
        <button onclick="window.print();" style="padding: 8px 16px; cursor: pointer;">Cetak Laporan</button>
        <button onclick="window.close();" style="padding: 8px 16px; margin-left: 10px; cursor: pointer;">Tutup</button>
    </div>
</body>
</html>
