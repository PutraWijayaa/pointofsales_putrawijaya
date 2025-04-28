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
                            <a href="{{ route('product.create') }}" class="btn btn-dark">
                                <span class="bi bi-plus-circle"></span> Add Product
                            </a>
                        </div>
                        <table class="table datatable table-hover">
                            <thead class="text-center">
                                <tr>
                                    <th>No</th>
                                    <th>Image</th>
                                    <th>Category</th>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Stock</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                    <th>Stock</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $no=1; @endphp
                                @foreach ($datas as $data)
                                <tr>
                                    <td class="text-center">{{ $no++ }}</td>
                                    <td class="text-center">
                                        <img class="rounded-circle" src="{{ asset('storage/' . $data->product_photo) }}" width="100px" height="100px" alt="">
                                    </td>
                                    <td>{{ $data->category->category_name }}</td>
                                    <td>{{ $data->product_name }}</td>
                                    <td>{{ number_format($data->product_price, 0, ',', '.') }}</td>
                                    <td class="text-center">{{ $data->stock }}</td>
                                    <td>{{ $data->is_active ? 'Active' : 'Draft' }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('product.edit', $data->id) }}" class="btn btn-dark btn-sm">
                                            <i class="bi bi-pencil"></i>
                                        </a>

                                        <a href="{{ route('product.destroy', $data->id) }}" class="btn btn-danger btn-sm" data-confirm-delete="true">
                                            <i class="bi bi-trash"></i>
                                        </a>


                                    </td>

                                    <td>
                                         <button class="btn btn-dark btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#addStockModal"
                                            data-product-id="{{ $data->id }}"
                                            data-product-name="{{ $data->product_name }}"
                                            data-product-stock="{{ $data->stock }}">
                                            <i class="bi bi-box-arrow-in-down"></i> In
                                        </button>

                                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#outStockModal"
                                            data-product-id="{{ $data->id }}"
                                            data-product-name="{{ $data->product_name }}"
                                            data-product-stock="{{ $data->stock }}">
                                            <i class="bi bi-box-arrow-up"></i> Out
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Modal Stock In -->
            <div class="modal fade" id="addStockModal" tabindex="-1" aria-labelledby="addStockModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <form action="{{ route('stock.in') }}" method="POST" id="addStockForm">
                        @csrf
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addStockModalLabel">Stock In</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="product_id" id="addModalProductId">
                                <p><strong>Product Name:</strong> <span id="addModalProductName"></span></p>
                                <p><strong>Current Stock:</strong> <span id="addModalProductStock"></span></p>

                                <div class="form-group mt-3">
                                    <label for="quantity">Quantity to Add</label>
                                    <input type="number" name="quantity" class="form-control" required min="1">
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success">Add Stock</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Modal Stock Out -->
            <div class="modal fade" id="outStockModal" tabindex="-1" aria-labelledby="outStockModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <form action="{{ route('stock.out') }}" method="POST" id="outStockForm">
                        @csrf
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="outStockModalLabel">Stock Out</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="product_id" id="outModalProductId">
                                <p><strong>Product Name:</strong> <span id="outModalProductName"></span></p>
                                <p><strong>Current Stock:</strong> <span id="outModalProductStock"></span></p>

                                <div class="form-group mt-3">
                                    <label for="quantity">Quantity to Subtract</label>
                                    <input type="number" name="quantity" class="form-control" required min="1">
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-warning">Reduce Stock</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
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
    // Stock In Modal
    const addStockModal = document.getElementById('addStockModal');
    addStockModal.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;
        document.getElementById('addModalProductId').value = button.getAttribute('data-product-id');
        document.getElementById('addModalProductName').textContent = button.getAttribute('data-product-name');
        document.getElementById('addModalProductStock').textContent = button.getAttribute('data-product-stock');
    });

    // Stock Out Modal
    const outStockModal = document.getElementById('outStockModal');
    outStockModal.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;
        document.getElementById('outModalProductId').value = button.getAttribute('data-product-id');
        document.getElementById('outModalProductName').textContent = button.getAttribute('data-product-name');
        document.getElementById('outModalProductStock').textContent = button.getAttribute('data-product-stock');
    });
});
</script>
@endsection
