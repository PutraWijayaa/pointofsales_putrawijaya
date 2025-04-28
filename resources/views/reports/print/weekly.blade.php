<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Penjualan Mingguan - Cetak</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        .letterhead {
            text-align: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #000;
        }
        .company-name {
            font-size: 22px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .company-info {
            font-size: 12px;
            color: #333;
        }
        .document-reference {
            text-align: right;
            margin: 15px 0 25px;
        }
        .document-reference table {
            border: none;
            width: auto;
            margin-left: auto;
        }
        .document-reference td {
            border: none;
            padding: 2px 5px;
        }
        .report-title {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            margin-top: 25px;
            text-decoration: underline;
        }
        .report-period {
            text-align: center;
            font-size: 14px;
            margin-bottom: 25px;
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
            border: 1px solid #000;
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
        .intro-text {
            margin-bottom: 20px;
        }
        .signature-section {
            display: flex;
            justify-content: space-between;
            margin-top: 50px;
        }
        .signature-box {
            width: 45%;
        }
        .right-aligned {
            text-align: right;
        }
        .signature-name {
            margin-top: 50px;
            font-weight: bold;
        }
        .conclusion-text {
            margin-top: 30px;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            color: #666;
            font-size: 12px;
            border-top: 1px solid #000;
            padding-top: 10px;
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
    <div class="letterhead">
        <div class="company-name">PPKD JAKARTA PUSAT</div>
        <div class="company-info">
            Jl. Teknologi Digital No. 123, Jakarta Selatan 12940<br>
            Telp: (021) 555-7890 | Email: info@posmeet.co.id | www.posmeet.co.id
        </div>
    </div>

    <div class="document-reference">
        <table>
            <tr>
                <td>Nomor</td>
                <td>: LPM/{{ date('Y/m/d', strtotime($weekStart)) }}</td>
            </tr>
            <tr>
                <td>Tanggal</td>
                <td>: {{ date('d F Y') }}</td>
            </tr>
            <tr>
                <td>Perihal</td>
                <td>: Laporan Penjualan Mingguan</td>
            </tr>
        </table>
    </div>

    <div class="report-title">LAPORAN PENJUALAN MINGGUAN</div>
    <div class="report-period">
        Periode: {{ date('d F Y', strtotime($weekStart)) }} - {{ date('d F Y', strtotime($weekEnd)) }}
    </div>

    <div class="intro-text">
        <p>Dengan hormat,</p>
        <p>Bersama ini kami sampaikan laporan penjualan mingguan untuk periode {{ date('d F Y', strtotime($weekStart)) }} sampai dengan {{ date('d F Y', strtotime($weekEnd)) }} dengan rincian sebagai berikut:</p>
    </div>

    <!-- <div class="summary-cards">
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
    </div> -->

    <div class="section-title">I. DETAIL PENJUALAN HARIAN</div>
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

    <!-- <div class="section-title">II. PRODUK TERLARIS</div>
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
    </table> -->

    <div class="conclusion-text">
        <p>Demikian laporan penjualan mingguan ini kami sampaikan. Semoga informasi ini dapat membantu dalam evaluasi kinerja penjualan dan pengambilan keputusan strategis perusahaan.</p>
    </div>

    <div class="signature-section">
        <div class="signature-box"></div>
        <div class="signature-box right-aligned">
            <p>Jakarta, {{ date('d F Y') }}</p>
            <p>Hormat kami,</p>
            <div class="signature-name">
                <p>( Nama Manajer Penjualan )</p>
                <p>Manajer Penjualan</p>
            </div>
        </div>
    </div>

    <!-- <div class="footer">
        © {{ date('Y') }} PPKD JAKARTA PUSAT. Hak Cipta Dilindungi.<br>
        Laporan ini bersifat rahasia dan hanya untuk penggunaan internal.
    </div> -->

    <div class="no-print" style="margin-top: 20px; text-align: center;">
        <button onclick="window.print();" style="padding: 8px 16px; cursor: pointer;">Cetak Laporan</button>
        <button onclick="window.close();" style="padding: 8px 16px; margin-left: 10px; cursor: pointer;">Tutup</button>
    </div>
</body>
</html>
