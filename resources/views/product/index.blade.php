@extends('layouts.main')
@section('title', 'Data Product')

@section('content')
<section class="section">
    <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ $title ?? '' }}</h5>
                    <div class="mt-4 mb-3">
                        <div align="right" class="mb-3">
                            <a href="{{ route('product.create') }}" class="btn btn-dark"><span
                                    class="bi bi-plus-circle"></span>
                                Add Product</a>
                        </div>
                        <table class="table datatable table-hover">
                            <thead class="text-center">
                                <tr>
                                    <th>No</th>
                                    <th>Image</th>
                                    <th>Category Product</th>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Stock</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                @php $no=1; @endphp
                                @foreach ($datas as $index => $data)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td class="text-center"><img class="rounded-circle"
                                            src="{{ asset('storage/' . $data->product_photo) }}" width="100px"
                                            height="100px" alt="">
                                    </td>
                                    <td>{{ $data->category->category_name }}</td>
                                    <td>{{ $data->product_name }}</td>
                                    <td>{{ $data->product_price }}</td>
                                    <td>{{ $data->stock }}</td>
                                    <td>{{ $data->is_active ? 'Active' : 'Draft' }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('product.edit', $data->id) }}" class="btn btn-dark"><i
                                                class="bi bi-pencil"></i></a>

                                        <a href="{{ route('product.destroy', $data->id) }}" class="btn btn-danger"
                                            data-confirm-delete="true"><i class="bi bi-trash"></i></a>

                                        <!-- Tombol untuk membuka modal -->
                                        <button class="btn btn-secondary" data-bs-toggle="modal"
                                            data-bs-target="#addStockModal" data-product-id="{{ $data->id }}"
                                            data-product-name="{{ $data->product_name }}"
                                            data-product-stock="{{ $data->stock }}">
                                            <i class="bi bi-plus-circle me-1"></i> Stok
                                        </button>


                                    </td>
                                </tr>
                                @endforeach
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>


            <!-- Modal Tambah Stok -->
            <div class="modal fade" id="addStockModal" tabindex="-1" aria-labelledby="addStockModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <form action="{{ route('stock.add') }}" method="POST" id="addStockForm">
                        @csrf
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addStockModalLabel">Tambah Stok Produk</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Tutup"></button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="product_id" id="modalProductId">
                                <p><strong>Nama Produk:</strong> <span id="modalProductName"></span></p>
                                <p><strong>Stok Saat Ini:</strong> <span id="modalProductStock"></span></p>

                                <div class="form-group mt-3">
                                    <label for="quantity">Jumlah Tambah Stok</label>
                                    <input type="number" name="quantity" class="form-control" required min="1">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-dark">Tambah</button>
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const addStockModal = document.getElementById('addStockModal');
    addStockModal.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;
        const productId = button.getAttribute('data-product-id');
        const productName = button.getAttribute('data-product-name');
        const productStock = button.getAttribute('data-product-stock');

        // Isi nilai ke dalam modal
        document.getElementById('modalProductId').value = productId;
        document.getElementById('modalProductName').textContent = productName;
        document.getElementById('modalProductStock').textContent = productStock;
    });
});
</script>

@endsection
