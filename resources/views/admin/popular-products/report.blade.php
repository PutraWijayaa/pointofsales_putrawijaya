<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Penjualan Produk</title>
    <style>
    body {
        font-family: 'Arial', sans-serif;
        line-height: 1.6;
        color: #333;
        max-width: 1000px;
        margin: 0 auto;
        padding: 20px;
    }

    .letterhead {
        text-align: center;
        border-bottom: 2px solid #1a3c6e;
        padding-bottom: 15px;
        margin-bottom: 20px;
    }

    .company-name {
        font-size: 24px;
        font-weight: bold;
        color: #1a3c6e;
        margin-bottom: 5px;
    }

    .company-details {
        font-size: 14px;
        color: #555;
    }

    .document-title {
        text-align: center;
        font-size: 20px;
        font-weight: bold;
        margin: 30px 0 20px 0;
        color: #1a3c6e;
    }

    .document-info {
        margin-bottom: 25px;
    }

    .document-info p {
        margin: 5px 0;
    }

    .section-title {
        font-size: 18px;
        font-weight: bold;
        color: #1a3c6e;
        margin: 25px 0 15px 0;
        border-bottom: 1px solid #ddd;
        padding-bottom: 5px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin: 20px 0;
    }

    th,
    td {
        border: 1px solid #ddd;
        padding: 10px;
        text-align: left;
    }

    th {
        background-color: #f2f6fc;
        color: #1a3c6e;
    }

    tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    .total-row {
        font-weight: bold;
        background-color: #e8eef7;
    }

    .conclusion {
        margin: 20px 0;
    }

    .signature {
        margin-top: 50px;
    }

    .footer {
        margin-top: 50px;
        text-align: center;
        font-style: italic;
        font-size: 12px;
        color: #777;
        border-top: 1px solid #ddd;
        padding-top: 10px;
    }

    .text-right {
        text-align: right;
    }

    .confidential {
        text-align: center;
        font-style: italic;
        color: #d32f2f;
        margin-top: 30px;
        border: 1px dashed #d32f2f;
        padding: 10px;
    }
    </style>
</head>

<body>
    <div class="letterhead">
        <div class="company-name">PPKD JAKARTA PUSAT</div>
        <div class="company-details">
            Jalan Utama No. 123, Jakarta Pusat<br>
            Telepon: (021) 123-4567 | Email: info@perusahaan.com<br>
            www.perusahaan.com
        </div>
    </div>

    <div class="document-title">LAPORAN PENJUALAN PRODUK</div>

    <div class="document-info">
        <p><strong>Nomor:</strong> {{ $reportNumber }}</p>
        <p><strong>Tanggal:</strong> 25 April 2025</p>
        <p><strong>Perihal:</strong> Ringkasan Produk Terlaris dan Pendapatan</p>
    </div>

    <div class="section-title">RINGKASAN EKSEKUTIF</div>
    <p>Dengan hormat,</p>
    <p>Bersama ini kami sampaikan laporan penjualan produk perusahaan yang mencakup daftar produk terlaris beserta total
        pendapatan yang dihasilkan. Laporan ini disusun sebagai bahan evaluasi kinerja penjualan dan pengambilan
        keputusan strategis perusahaan.</p>

    <div class="section-title">DAFTAR PRODUK TERLARIS</div>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Nama Produk</th>
                    <th>Kategori</th>
                    <th>Harga Satuan (Rp)</th>
                    <th>Jumlah Terjual</th>
                    <th>Pendapatan (Rp)</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($popularProducts as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->product->product_name }}</td>
                    <td>{{ $item->product->category->category_name }}</td>
                    <td class="text-right">{{ number_format($item->product->product_price, 2) }}</td>
                    <td class="text-right">{{ $item->total_ordered }}</td>
                    <td class="text-right">{{ number_format($item->total_revenue, 2) }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align: center;">Tidak ada data produk tersedia</td>
                </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr class="total-row">
                    <td colspan="5" class="text-right"><strong>Total Pendapatan:</strong></td>
                    <td class="text-right"><strong>Rp
                            {{ number_format($popularProducts->sum('total_revenue'), 2) }}</strong></td>
                </tr>
            </tfoot>
        </table>
    </div>

    <div class="conclusion">
        <p>Berdasarkan data penjualan di atas, dapat disimpulkan bahwa produk-produk tersebut memberikan kontribusi
            signifikan terhadap pendapatan perusahaan. Direkomendasikan untuk melakukan:</p>
        <ol>
            <li>Peningkatan stok pada produk dengan penjualan tertinggi</li>
            <li>Evaluasi strategi pemasaran untuk produk dengan kategori serupa</li>
            <li>Analisis lebih lanjut terhadap pola pembelian konsumen</li>
        </ol>
    </div>

    <div class="signature">
        <p>Hormat kami,</p>
        <br><br><br>
        <p><strong>Nama Direktur</strong><br>
            Direktur Penjualan<br>
            PT. NAMA PERUSAHAAN</p>
    </div>

    <script>
    window.onload = function() {
        window.print();
    }
    </script>
</body>

</html>
