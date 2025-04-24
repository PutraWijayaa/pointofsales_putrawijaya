@extends('layouts.main')

@section('title', 'Kasir Dashboard')

@section('content')
<div class="container-fluid px-4">
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Dashboard</li>
    </ol>

    <!-- Summary Cards -->
    <div class="row">
        <!-- Today's Transactions Card -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Transaksi Hari Ini</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $todayTransactions ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-shopping-cart fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Today's Sales Card -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total Penjualan Hari Ini</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Rp {{ number_format($todaySales ?? 0, 0, ',', '.') }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Products Count Card -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Total Produk Tersedia</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalProducts ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-boxes fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Action Cards -->
    <div class="row mb-4">
        <!-- POS Button -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow h-100">
                <div class="card-body">
                    <div class="text-center">
                        <a href="{{ route('pos.index') }}" class="btn btn-primary btn-lg p-5 w-100">
                            <i class="fas fa-cash-register fa-3x mb-3"></i>
                            <h3>Mulai Transaksi Baru</h3>
                            <p class="mt-2">Proses penjualan produk</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stock Products Button -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow h-100">
                <div class="card-body">
                    <div class="text-center">
                        <a href="{{ route('stock-products.index') }}" class="btn btn-success btn-lg p-5 w-100">
                            <i class="fas fa-warehouse fa-3x mb-3"></i>
                            <h3>Lihat Stok Produk</h3>
                            <p class="mt-2">Cek ketersediaan produk</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Today's Transactions -->
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Transaksi Hari Ini</h6>
                    <a href="{{ route('transactions.today') }}" class="btn btn-sm btn-primary">Lihat Semua</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Kode Order</th>
                                    <th>Waktu</th>
                                    <th>Total Belanja</th>
                                    <th>Pembayaran</th>
                                    <th>Kembalian</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentTransactions ?? [] as $transaction)
                                <tr>
                                    <td>{{ $transaction->order_code }}</td>
                                    <td>{{ \Carbon\Carbon::parse($transaction->created_at)->format('H:i') }}</td>
                                    <td>Rp {{ number_format($transaction->order_subtotal, 0, ',', '.') }}</td>
                                    <td>Rp {{ number_format($transaction->order_amount, 0, ',', '.') }}</td>
                                    <td>Rp {{ number_format($transaction->order_change, 0, ',', '.') }}</td>
                                    <td>
                                        @if($transaction->order_status == 1)
                                            <span class="badge bg-success">Selesai</span>
                                        @else
                                            <span class="badge bg-warning">Pending</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('pos.receipt', $transaction->id) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-receipt"></i> Struk
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center">Belum ada transaksi hari ini</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Popular Products -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Produk Populer</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        @forelse($popularProducts ?? [] as $product)
                            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                                <div class="card h-100">
                                    @if($product->product_photo)
                                        <img src="{{ asset('storage/'.$product->product_photo) }}" class="card-img-top" alt="{{ $product->product_name }}" style="height: 160px; object-fit: cover;">
                                    @else
                                        <div class="bg-light text-center py-5">
                                            <i class="fas fa-image fa-3x text-secondary"></i>
                                        </div>
                                    @endif
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $product->product_name }}</h5>
                                        <p class="card-text text-primary font-weight-bold">Rp {{ number_format($product->product_price, 0, ',', '.') }}</p>
                                        <p class="card-text"><small class="text-muted">{{ $product->category->category_name ?? 'Tanpa Kategori' }}</small></p>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12 text-center py-3">
                                <p class="mb-0">Belum ada data produk populer</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Any dashboard-specific JavaScript can go here
    });
</script>
@endsection
