@extends('layouts.main')

@section('content')
<div class="pagetitle">
    <h1>Riwayat Stok Produk</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Riwayat Stok</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section">
    <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <div class="card-body">
                    <a href="{{ route('stok.cetakHis') }}" target="_blank" class="btn btn-dark mt-3">
                        <i class="bx bx-printer"></i> Cetak
                    </a>
                    <div class="table-responsive mt-5">
                        <table class="table datatable table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Produk</th>
                                    <th>Jumlah Perubahan</th>
                                    <th>Jenis Transaksi</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($stockHistories as $index => $history)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $history->product->product_name }}</td>
                                    <td>
                                        @if($history->stock_change > 0)
                                        <span class="badge bg-success">+{{ $history->stock_change }}</span>
                                        @elseif($history->stock_change < 0) <span class="badge bg-danger">
                                            -{{ abs($history->stock_change) }}</span>
                                            @else
                                            <span class="badge bg-secondary">0</span>
                                            @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-{{
                                            match($history->transaction_type) {
                                                'stock_in' => 'success',
                                                'stock_out' => 'danger',
                                                'sale' => 'warning',
                                                default => 'secondary'
                                                }
                                            }}">
                                            {{ ucfirst(str_replace('_', ' ', $history->transaction_type)) }}
                                        </span>
                                    </td>
                                    <td>{{ $history->created_at->format('d-m-Y H:i') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

        </div>
    </div>
</section>
@endsection
