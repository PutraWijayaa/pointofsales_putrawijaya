<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Laporan Harian Penjualan - {{ \Carbon\Carbon::parse($selectedDate)->format('d M Y') }}</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt;
            margin: 40px;
            color: #000;
            line-height: 1.5;
        }

        .letterhead {
            text-align: center;
            border-bottom: 2px solid #000;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }

        .company-name {
            font-size: 22pt;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .company-info {
            font-size: 10pt;
        }

        .document-title {
            text-align: center;
            font-size: 16pt;
            font-weight: bold;
            margin: 30px 0 10px;
            text-decoration: underline;
        }

        .document-subtitle {
            text-align: center;
            font-size: 14pt;
            margin: 0 0 30px;
        }

        .report-info {
            margin: 20px 0;
        }

        .section-title {
            font-size: 14pt;
            font-weight: bold;
            margin: 25px 0 15px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        table, th, td {
            border: 1px solid #000;
        }

        th {
            background-color: #f2f2f2;
            padding: 10px;
            text-align: center;
            font-weight: bold;
        }

        td {
            padding: 8px;
            text-align: left;
        }

        .signature-section {
            margin-top: 50px;
            display: flex;
            justify-content: space-between;
        }

        .signature-box {
            width: 45%;
        }

        .right-aligned {
            text-align: right;
        }

        .signature-title {
            font-weight: bold;
            margin-bottom: 60px;
        }

        .footer {
            margin-top: 50px;
            font-size: 10pt;
            text-align: center;
            border-top: 1px solid #000;
            padding-top: 10px;
        }

        .reference-number {
            margin-bottom: 30px;
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
    <div class="letterhead">
        <div class="company-name">PPKD JAKARTA PUSAT</div>
        <div class="company-info">
            Jl. Jenderal Sudirman No. 123, Jakarta Pusat 10220<br>
            Telp: (021) 555-1234 | Fax: (021) 555-5678 | Email: info@perusahaan.co.id<br>
            www.perusahaan.co.id
        </div>
    </div>

    <div class="reference-number">
        <table style="border: none; width: auto;">
            <tr style="border: none;">
                <td style="border: none; padding: 2px;">Nomor</td>
                <td style="border: none; padding: 2px;">: LHP/{{ \Carbon\Carbon::parse($selectedDate)->format('Y/m/d') }}</td>
            </tr>
            <tr style="border: none;">
                <td style="border: none; padding: 2px;">Tanggal</td>
                <td style="border: none; padding: 2px;">: {{ \Carbon\Carbon::parse($selectedDate)->format('d F Y') }}</td>
            </tr>
            <tr style="border: none;">
                <td style="border: none; padding: 2px;">Lampiran</td>
                <td style="border: none; padding: 2px;">: -</td>
            </tr>
            <tr style="border: none;">
                <td style="border: none; padding: 2px;">Hal</td>
                <td style="border: none; padding: 2px;">: Laporan Harian Penjualan</td>
            </tr>
        </table>
        <div style="clear: both;"></div>
    </div>

    <div class="document-title">LAPORAN HARIAN PENJUALAN</div>
    <div class="document-subtitle">Periode: {{ \Carbon\Carbon::parse($selectedDate)->format('d F Y') }}</div>

    <div class="report-info">
        <p>Dengan hormat,</p>
        <p>Bersama ini kami sampaikan laporan harian penjualan untuk tanggal {{ \Carbon\Carbon::parse($selectedDate)->format('d F Y') }} dengan rincian sebagai berikut:</p>

        <table style="border: none; width: 80%; margin: 20px auto;">
            <tr style="border: none;">
                <td style="border: none; padding: 2px; width: 40%;"><strong>Total Penjualan</strong></td>
                <td style="border: none; padding: 2px;">: Rp{{ number_format($totalSales, 0, ',', '.') }}</td>
            </tr>
            <tr style="border: none;">
                <td style="border: none; padding: 2px; width: 40%;"><strong>Total Pesanan</strong></td>
                <td style="border: none; padding: 2px;">: {{ $totalOrders }} transaksi</td>
            </tr>
        </table>
    </div>

    <div class="section-title">DAFTAR PESANAN</div>
    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>Tanggal</th>
                <th>Kode Pesanan</th>
                <th>Jumlah Item</th>
                <th>Total Bayar</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($Orders as $order)
                <tr>
                    <td style="text-align: center;">{{ $loop->iteration }}</td>
                    <td>{{ \Carbon\Carbon::parse($order->order_date)->format('d-m-Y') }}</td>
                    <td>{{ $order->order_code ?? '-' }}</td>
                    <td style="text-align: center;">{{ $order->OrderDetails->sum('qty') }}</td>
                    <td style="text-align: right;">Rp{{ number_format($order->order_amount, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align: center;">Tidak ada data pesanan</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <p>Demikian laporan ini kami sampaikan. Atas perhatian Bapak/Ibu, kami ucapkan terima kasih.</p>

    <div class="signature-section">
        <div class="signature-box"></div>
        <div class="signature-box right-aligned">
            <p>Jakarta, {{ \Carbon\Carbon::parse($selectedDate)->format('d F Y') }}</p>
            <p class="signature-title">Manajer Penjualan</p>
            <p><strong>( __________________ )</strong></p>
            <p><strong>NIP. _______________</strong></p>
        </div>
    </div>

    <!-- <div class="footer">
        <p>Dokumen ini dicetak pada: {{ now()->format('d-m-Y H:i') }} dan merupakan dokumen resmi perusahaan.</p>
    </div> -->

    <script>
        window.onload = function() {
            window.print();
        };
    </script>
</body>
</html>
