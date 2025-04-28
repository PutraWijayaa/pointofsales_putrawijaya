@extends('layouts.main')

@section('content')
<div class="pagetitle">
  <h1>Popular Products</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
      <li class="breadcrumb-item active">Popular Products</li>
    </ol>
  </nav>
</div><!-- End Page Title -->

<section class="section">
  <div class="row">
    <div class="col-lg-12">

      <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h5 class="card-title mb-0">Top 10 Produk Terlaris</h5>
          <a href="{{ route('popular-products.report') }}" target="_blank" class="btn btn-dark">
            <i class="bi bi-printer"></i> Cetak Laporan
          </a>
        </div>
        <div class="card-body">

          @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              {{ session('success') }}
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          @endif

          <div class="table-responsive">
            <table class="table datatable table-hover">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Produk</th>
                  <th>Kategori</th>
                  <th>Harga</th>
                  <th>Total Terjual</th>
                </tr>
              </thead>
              <tbody>
                @forelse ($popularProducts as $index => $item)
                <tr>
                  <td>{{ $index + 1 }}</td>
                  <td>
                    @if($item->product->product_photo)
                      <img src="{{ asset('storage/' . $item->product->product_photo) }}" alt="{{ $item->product->product_name }}" width="50" class="me-2">
                    @endif
                    {{ $item->product->product_name }}
                  </td>
                  <td>{{ $item->product->category->category_name }}</td>
                  <td>Rp {{ number_format($item->product->product_price, 2, ',', '.') }}</td>
                  <td>{{ $item->total_ordered }}</td>
                </tr>
                @empty
                <tr>
                  <td colspan="5" class="text-center">Tidak ada data produk terlaris.</td>
                </tr>
                @endforelse
              </tbody>
            </table>
          </div>

        </div>
      </div>

    </div>
  </div>
</section>
@endsection
