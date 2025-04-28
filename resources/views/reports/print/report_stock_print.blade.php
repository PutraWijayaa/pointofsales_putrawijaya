@extends('layouts.main')

@section('content')
<section class="section">
    <div class="row justify-content-center">
        <div class="col-lg-10">

            <!-- Tombol Cetak -->
            <div class="text-end mb-3 d-print-none">
                <a href="{{ route('stok.cetak') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
                <button class="btn btn-dark" onclick="window.print()">
                    <i class="fas fa-print"></i> Cetak
                </button>
            </div>

            <!-- Kop Surat -->
            <div class="text-center border-bottom pb-2 mb-4">
                <h4 class="mb-0">PPKD JAKARTA PUSAT</h4>
                <p class="mb-0">Jl. Raya Bisnis No. 123, Jakarta</p>
                <p class="mb-0">Telp: (021) 12345678 | Email: info@contohperusahaan.co.id</p>
                <hr style="border: 2px solid #000; width: 100px; margin: 10px auto;">
                <h5 class="mt-3"><strong>LAPORAN STOK PRODUK</strong></h5>
                <p><strong>Tanggal: {{ \Carbon\Carbon::now()->format('d-m-Y') }}</strong></p>
            </div>

            <!-- Tabel Laporan -->
            <table class="table table-bordered table-sm">
                <thead class="table-light">
                    <tr>
                        <th style="width: 50px;">No</th>
                        <th>Nama Produk</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($products as $index => $product)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $product->product_name }}</td>
                        <td>Rp {{ number_format($product->product_price, 2, ',', '.') }}</td>
                        <td>{{ $product->stock }}</td>
                        <td>
                            @if ($product->stock == 0)
                                Habis
                            @elseif ($product->stock <= 5)
                                Hampir Habis
                            @else
                                Tersedia
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">Data tidak tersedia</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Tanda Tangan -->
            <div class="row mt-5">
                <div class="col-6">
                    <p><strong>Dicetak oleh:</strong></p>
                    <p>Admin</p>
                </div>
                <div class="col-6 text-end">
                    <p><strong>Mengetahui,</strong></p>
                    <p>Manager Operasional</p>
                    <br><br>
                    <p><strong>(__________________)</strong></p>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Style khusus cetak -->
<style>
    @media print {
        body {
            font-size: 12px;
            color: #000;
        }

        .d-print-none {
            display: none !important;
        }

        table {
            width: 100% !important;
            border-collapse: collapse !important;
        }

        table, th, td {
            border: 1px solid black !important;
        }
    }
</style>
@endsection
