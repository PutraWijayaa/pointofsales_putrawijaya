@extends('layouts.main')

@section('title', 'Kasir Dashboard')

@section('content')
<div class="pagetitle">
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item active">Dashboard</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section dashboard">
    <div class="row">

        <!-- Left side columns -->
        <div class="col-lg-12">
            <div class="row">

                <!-- Tombol Aksi -->
                <div class="col-md-6">
                    <div class="card info-card">
                        <div class="card-body text-center">
                            <a href="{{ route('pos.create') }}" class="btn btn-primary w-100 py-4" target="_blank">
                                <i class="bx bx-receipt bx-lg d-block mb-2"></i>
                                <h5 class="mb-0">Mulai Transaksi Baru</h5>
                                <small>Proses penjualan produk</small>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card info-card">
                        <div class="card-body text-center">
                            <a href="{{ route('stock-products.index') }}" class="btn btn-success w-100 py-4">
                                <i class="bx bx-store-alt bx-lg d-block mb-2"></i>
                                <h5 class="mb-0">Lihat Stok Produk</h5>
                                <small>Cek ketersediaan barang</small>
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div><!-- End Left side columns -->

    </div>
</section>
@endsection
