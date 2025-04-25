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
                                    Add New</a>
                            </div>
                            <table class="table table-bordered">
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
                                            <td class="text-center"><img
                                                    src="{{ asset('storage/' . $data->product_photo) }}" width="150px">
                                            </td>
                                            <td>{{ $data->category->category_name }}</td>
                                            <td>{{ $data->product_name }}</td>
                                            <td>{{ $data->product_price }}</td>
                                            <td>{{ $data->qty_akhir }}</td>
                                            <td>{{ $data->is_active ? 'Active' : 'Draft' }}</td>
                                            <td class="text-center">
                                                <a href="{{ route('product.edit', $data->id) }}" class="btn btn-dark"><i
                                                        class="bi bi-pencil"></i></a>

                                                <a href="{{ route('product.destroy', $data->id) }}" class="btn btn-danger"
                                                    data-confirm-delete="true"><i class="bi bi-trash"></i></a>

                                            </td>
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
