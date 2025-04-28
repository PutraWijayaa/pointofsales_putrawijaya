<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Penjualan Bulanan - Cetak</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            margin: 0;
            padding: 20px;
            color: #333;
            line-height: 1.6;
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
            text-align: left;
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
                margin: 10mm;
                padding: 0;
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
                <td>: LPB/{{ date('Y/m', strtotime($monthStart)) }}</td>
            </tr>
            <tr>
                <td>Tanggal</td>
                <td>: {{ date('d F Y') }}</td>
            </tr>
            <tr>
                <td>Perihal</td>
                <td>: Laporan Penjualan Bulanan</td>
            </tr>
        </table>
    </div>

    <div class="report-title">LAPORAN PENJUALAN BULANAN</div>
    <div class="report-period">
        Periode: {{ date('d F Y', strtotime($monthStart)) }} - {{ date('d F Y', strtotime($monthEnd)) }}
    </div>

    <div class="intro-text">
        <p>Dengan hormat,</p>
        <p>Bersama ini kami sampaikan laporan penjualan bulanan untuk periode {{ date('d F Y', strtotime($monthStart)) }} sampai dengan {{ date('d F Y', strtotime($monthEnd)) }} dengan rincian sebagai berikut:</p>
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
                <td colspan="3" class="no-data">Tidak ada data penjualan harian</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="section-title">II. RINGKASAN PENJUALAN MINGGUAN</div>
    <table>
        <thead>
            <tr>
                <th>Minggu</th>
                <th>Tanggal Mulai</th>
                <th>Tanggal Selesai</th>
                <th class="text-right">Transaksi</th>
                <th class="text-right">Penjualan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($weeklySales as $week)
            <tr>
                <td>{{ $week->year_week }}</td>
                <td>{{ date('d M Y', strtotime($week->start_date)) }}</td>
                <td>{{ date('d M Y', strtotime($week->end_date)) }}</td>
                <td class="text-right">{{ $week->order_count }}</td>
                <td class="text-right">Rp {{ number_format($week->total_sales, 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="no-data">Tidak ada data mingguan</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <!-- <div class="section-title">III. PRODUK TERLARIS</div>
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

    <div class="section-title">III. PENJUALAN BERDASARKAN KATEGORI</div>
    <table>
        <thead>
            <tr>
                <th>Kategori</th>
                <th class="text-right">Jumlah Produk</th>
                <th class="text-right">Qty Terjual</th>
                <th class="text-right">Penjualan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($categorySales as $category)
            <tr>
                <td>{{ $category->category_name }}</td>
                <td class="text-right">{{ $category->product_count }}</td>
                <td class="text-right">{{ $category->total_qty }}</td>
                <td class="text-right">Rp {{ number_format($category->total_amount, 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="no-data">Tidak ada data kategori</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="conclusion-text">
        <p>Demikian laporan penjualan bulanan ini kami sampaikan. Semoga informasi ini dapat membantu dalam pengambilan keputusan strategis perusahaan.</p>
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

    <div class="footer">
        © {{ date('Y') }} PPKD JAKARTA PUSAT. Hak Cipta Dilindungi.<br>
        Dokumen ini bersifat rahasia dan hanya untuk penggunaan internal perusahaan.
    </div>

    <div class="no-print" style="text-align: center; margin-top: 20px;">
        <button onclick="window.print();" style="padding: 8px 16px; cursor: pointer;">Cetak Laporan</button>
        <button onclick="window.close();" style="padding: 8px 16px; margin-left: 10px; cursor: pointer;">Tutup</button>
    </div>
</body>
</html>
