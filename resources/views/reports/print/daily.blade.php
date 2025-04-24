<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Laporan Harian Penjualan - {{ \Carbon\Carbon::parse($selectedDate)->format('d M Y') }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            margin: 20px;
            color: #333;
        }

        h2, h4 {
            text-align: center;
            margin: 0;
        }

        .info {
            margin: 20px 0;
        }

        .info p {
            margin: 5px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        table, th, td {
            border: 1px solid #aaa;
        }

        th, td {
            padding: 8px;
            text-align: left;
        }

        .total {
            font-weight: bold;
        }

        .footer {
            margin-top: 30px;
            text-align: right;
        }

        .print-btn {
            display: none;
        }

        @media print {
            .print-btn {
                display: none;
            }
        }
    </style>
</head>
<body>
    <h2>Laporan Harian Penjualan</h2>
    <h4>{{ \Carbon\Carbon::parse($selectedDate)->format('d F Y') }}</h4>

    <div class="info">
        <p><strong>Total Penjualan:</strong> Rp{{ number_format($totalSales, 0, ',', '.') }}</p>
        <p><strong>Total Pesanan:</strong> {{ $totalOrders }} transaksi</p>
    </div>

    <h4>Daftar Pesanan</h4>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Tanggal</th>
                <th>Kode Pesanan</th>
                <th>Jumlah Item</th>
                <th>Total Bayar</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($Orders as $order)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ \Carbon\Carbon::parse($order->order_date)->format('d-m-Y') }}</td>
                    <td>{{ $order->order_code ?? '-' }}</td>
                    <td>{{ $order->OrderDetails->sum('qty') }}</td>
                    <td>Rp{{ number_format($order->order_amount, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align: center;">Tidak ada data pesanan</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <h4>5 Produk Terlaris</h4>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Produk</th>
                <th>Kategori</th>
                <th>Jumlah Terjual</th>
                <th>Total Penjualan</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($topProducts as $product)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $product->product_name }}</td>
                    <td>{{ $product->category_name }}</td>
                    <td>{{ $product->total_qty }}</td>
                    <td>Rp{{ number_format($product->total_amount, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align: center;">Tidak ada data</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Dicetak pada: {{ now()->format('d-m-Y H:i') }}</p>
    </div>

    <script>
        window.onload = function() {
            window.print();
        };
    </script>
</body>
</html>
