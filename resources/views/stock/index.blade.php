@extends('layouts.main')

@section('content')
<div class="pagetitle">
    <h1>Laporan Stok Produk</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Laporan Stok</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body pt-4">
                    <h5 class="card-title">Data Stok Produk</h5>

                    <table class="table table-hover datatable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Produk</th>
                                <th>Harga</th>
                                <th>Stok</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $index => $product)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $product->product_name }}</td>
                                <td>Rp {{ number_format($product->product_price, 2, ',', '.') }}</td>
                                <td>{{ $product->stock }}</td>
                                <td>
                                    @if ($product->stock == 0)
                                        <span class="badge bg-danger">Habis</span>
                                    @elseif ($product->stock <= 5)
                                        <span class="badge bg-warning text-dark">Hampir Habis</span>
                                    @else
                                        <span class="badge bg-success">Tersedia</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</section>
@endsection
