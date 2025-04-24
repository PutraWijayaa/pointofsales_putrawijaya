<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Strukt</title>
    <style>
        body {
            width: 70mm;
            margin: 0 auto;
            font-family: 'Courier New', Courier, monospace;
            font-size: 12px;
            color: #000;
        }

        header {
            text-align: center;
            font-weight: bold;
        }

        header h3 {}

        header p {
            font-weight: bold;
        }

        .divider {
            border-top: 1px dashed #000;
            margin: 5px 0;
        }

        .item-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 2px;
        }

        .item-row .left {
            flex: 1;
        }

        .item-row .right {
            flex: 0 0 auto;
            text-align: right;
        }

        .footer {
            margin-top: 10px;
        }

        @media print {
            body {
                margin: 0;
            }
        }
    </style>
</head>

<body onload="window.print()">
    <div class="wrapper">
        <header>
            <img src="https://www.tuku.coffee/favicon.ico" alt="" width="150px">
            <h3>TOKO KOPI TETANGGA</h3>
            <p>Jl Setiabudi Selatan, Karet Setiabudi, Jakarta Selatan, DKI Jakarta</p>
            <p>No Telp 081382932816</p>
        </header>
        <div class="divider"></div>
        <div>
            <div>Tanggal : {{ date('d-M-Y', strtotime($order->order_date)) }} </div>
            <div>No Transaksi : {{ $order->order_code }} </div>

        </div>
        <div class="divider"></div>
        @foreach ($orderDetails as $orderDetail)
            <div class="item-row">
                <div class="left">{{ $orderDetail->product->product_name ?? '' }} :</div>
                <div class="right">{{ number_format($orderDetail->order_subtotal) }}</div>
            </div>
            <div class="item-row">
                <div class="left">{{ $orderDetail->qty }} x {{ number_format($orderDetail->order_price) }}</div>
            </div>
        @endforeach

        <div class="item-row">

            <div class="left">{{ number_format($order->order_amount) }}</div>
            <div class="right"></div>
        </div>

    </div>

</body>

</html>
