<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Transaksi</title>
    <style>
        /* Reset semua margin dan padding */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            width: 80mm; /* Lebar standar thermal printer */
            margin: 0 auto;
            font-family: 'Courier New', monospace;
            font-size: 14px; /* Ukuran font lebih kecil */
            color: #000;
            line-height: 1.2;
            padding: 2mm; /* Padding kecil */
        }

        /* Header styling */
        .header {
            text-align: center;
            margin-bottom: 5px;
            padding-bottom: 5px;
            border-bottom: 1px dashed #000;
        }

        .logo {
            text-align: center;
            margin-bottom: 3px;
        }

        .logo img {
            max-width: 60px; /* Logo lebih kecil */
            height: auto;
        }

        .store-name {
            font-weight: bold;
            font-size: 16px;
            margin-bottom: 2px;
            text-transform: uppercase;
        }

        .store-address {
            font-size: 12px;
            margin-bottom: 2px;
        }

        .store-contact {
            font-size: 12px;
            margin-bottom: 3px;
        }

        /* Divider */
        .divider {
            border-top: 1px dashed #000;
            margin: 3px 0;
        }

        .divider-thick {
            border-top: 2px solid #000;
            margin: 4px 0;
        }

        /* Transaction info */
        .transaction-info {
            margin-bottom: 5px;
        }

        .transaction-info div {
            margin-bottom: 2px;
        }

        /* Items list */
        .items {
            margin: 5px 0;
        }

        .item-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 3px;
        }

        .item-name {
            flex: 2;
            font-weight: bold;
        }

        .item-price {
            flex: 1;
            text-align: right;
        }

        .item-detail {
            font-size: 12px;
            margin-left: 10px;
            margin-bottom: 2px;
            color: #555;
        }

        /* Totals */
        .totals {
            margin-top: 5px;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 3px;
        }

        .total-label {
            font-weight: bold;
        }

        .total-value {
            font-weight: bold;
            text-align: right;
        }

        /* Footer */
        .footer {
            margin-top: 10px;
            text-align: center;
            font-size: 12px;
        }

        .thank-you {
            margin-bottom: 5px;
            font-weight: bold;
        }

        /* Print specific styles */
        @media print {
            body {
                width: 80mm;
                margin: 0;
                padding: 2mm;
                font-size: 14px;
            }

            /* Hide non-print elements */
            .no-print {
                display: none !important;
            }

            /* Ensure no page breaks */
            .item-row, .total-row {
                page-break-inside: avoid;
            }
        }
    </style>
</head>

<body onload="window.print()">
    <div class="wrapper">
        <!-- Header Section -->
        <div class="header">
            <div class="logo">
                <img src="{{ asset('assets/img/404.png') }}" alt="Logo Toko">
            </div>
            <div class="store-name">PPKD JAKARTA PUSAT</div>
            <div class="store-address">Jl Setiabudi Selatan, Karet Setiabudi</div>
            <div class="store-address">Jakarta Selatan, DKI Jakarta</div>
            <div class="store-contact">Telp: 081382932816</div>
        </div>

        <!-- Transaction Info -->
        <div class="transaction-info">
            <div>Tanggal: {{ date('d-M-Y H:i', strtotime($order->order_date)) }}</div>
            <div>No Transaksi: {{ $order->order_code }}</div>
            <div>Kasir: {{ Auth::user()->name ?? 'System' }}</div>
        </div>

        <div class="divider"></div>

        <!-- Items List -->
        <div class="items">
            @foreach ($orderDetails as $orderDetail)
                <div class="item-row">
                    <div class="item-name">{{ $orderDetail->product->product_name ?? 'Produk' }}</div>
                    <div class="item-price">{{ number_format($orderDetail->order_subtotal) }}</div>
                </div>
                <div class="item-detail">
                    {{ $orderDetail->qty }} x @ {{ number_format($orderDetail->order_price) }}
                </div>
            @endforeach
        </div>

        <div class="divider-thick"></div>

        <!-- Totals Section -->
        <div class="totals">
            <div class="total-row">
                <div class="total-label">Subtotal:</div>
                <div class="total-value">{{ number_format($order->order_amount) }}</div>
            </div>
            <div class="total-row">
                <div class="total-label">Pembayaran:</div>
                <div class="total-value">{{ number_format($order->order_amount + $order->order_change) }}</div>
            </div>
            <div class="total-row">
                <div class="total-label">Kembalian:</div>
                <div class="total-value">{{ number_format($order->order_change) }}</div>
            </div>
        </div>

        <div class="divider"></div>

        <!-- Footer Section -->
        <div class="footer">
            <div class="thank-you">TERIMA KASIH</div>
            <div>Barang yang sudah dibeli tidak dapat ditukar/dikembalikan</div>
            <div>-- {{ date('d-M-Y H:i') }} --</div>
        </div>
    </div>

    <!-- Print automatically -->
    <script>
        window.onload = function() {
            window.print();
            setTimeout(function() {
                window.close();
            }, 1000);
        };
    </script>
</body>

</html>
