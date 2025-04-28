<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Riwayat Stok Produk</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            border-bottom: 3px double #000;
            padding-bottom: 15px;
        }
        .logo {
            width: 120px;
        }
        .company-info {
            text-align: center;
            flex-grow: 1;
        }
        .company-name {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .company-address {
            font-size: 12px;
            margin-bottom: 5px;
        }
        .title {
            text-align: center;
            margin: 20px 0;
            font-size: 16px;
            font-weight: bold;
            text-decoration: underline;
        }
        .document-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }
        th, td {
            border: 1px solid #000;
            padding: 5px 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .text-center{
            text-align: center;
        }
        .footer {
            margin-top: 30px;
            display: flex;
            justify-content: space-between;
            font-size: 12px;
        }
        .signature {
            text-align: center;
            width: 200px;
        }
        .signature-space {
            height: 50px;
            border-bottom: 1px solid #000;
            margin-bottom: 5px;
        }
        .badge {
            padding: 2px 5px;
            border-radius: 3px;
            font-size: 11px;
            font-weight: bold;
        }
        .badge-success {
            background-color: #d4edda;
            color: #155724;
        }
        .badge-danger {
            background-color: #f8d7da;
            color: #721c24;
        }
        .badge-primary {
            background-color: #cce5ff;
            color: #004085;
        }
        .badge-warning {
            background-color: #fff3cd;
            color: #856404;
        }
        .page-break {
            page-break-after: always;
        }
        .text-right{
            text-align: right;
        }
    </style>
</head>
<body>

    <div class="header">
        <div class="logo">
            <!-- Logo -->
            <!-- <img src="{{ asset('path/to/company/logo.png') }}" alt="Company Logo" style="max-width: 100%;"> -->
        </div>
        <div class="company-info">
            <div class="company-name">PPKD JAKARTA PUSAT</div>
            <div class="company-address">Jl. Alamat Perusahaan No. 123, Kota, Provinsi</div>
            <div class="company-address">Telp: (021) 12345678 | Email: info@perusahaan.com</div>
        </div>
        <div style="width: 120px;"></div>
    </div>

    <div class="title">LAPORAN RIWAYAT PERUBAHAN STOK PRODUK</div>

    <div class="document-info">
        <div>Tanggal Cetak: {{ date('d F Y') }}</div>
        <div>Halaman: 1</div>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Produk</th>
                <th>Stock</th>
                <th>Jenis Transaksi</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($stockHistories as $index => $history)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $history->product->product_name }}</td>
                <td class="text-center">
                    @if($history->stock_change > 0)
                    <span class="badge badge-success">+{{ $history->stock_change }}</span>
                    @else
                    <span class="badge badge-danger">{{ $history->stock_change }}</span>
                    @endif
                </td>
                <td class="text-center">
                    <span class="badge badge-{{ $history->transaction_type == 'restock' ? 'primary' : 'warning' }}">
                        {{ ucfirst($history->transaction_type) }}
                    </span>
                </td>
                <td class="text-right">{{ $history->created_at->format('d-m-Y H:i') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <div style="width: 200px;"></div>
        <div class="signature">
            <div>Kota, {{ date('d F Y') }}</div>
            <div class="signature-space"></div>
            <div>(Manager Gudang)</div>
        </div>
    </div>
</body>
</html>
