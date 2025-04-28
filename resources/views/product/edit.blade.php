@extends('layouts.main')
@section('title', 'Add New product')
@section('content')


    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">
                            Edit Data Product
                        </h5>

                        <form action="{{ route('product.update', $edit->id) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('put')

                            <div class="mb-3">
                                <label class="mb-3" for="">Product Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="product_name"
                                    value="{{ $edit->product_name }}">
                            </div>

                            <div class="mb-3">
                                <label class="mb-3" for="">Price <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" name="product_price" id=""
                                    placeholder="Enter Category Name" value="{{ $edit->product_price }}">
                            </div>

                            <div class="mb-3">
                                <label class="mb-3" for="">Category Name</label>
                                <select id="category_id" name="category_id" class="form-select">
                                    <option selected="">-- Option --</option>
                                    @foreach ($categories as $category)
                                        <option {{ $edit->category_id == $category->id ? 'selected' : '' }}
                                            value="{{ $category->id }}">
                                            {{ $category->category_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <table class="table table-bordered">
                                <tr>
                                    <td>
                                        <label for="" style="font-weight: 900">Status <span
                                                class="text-danger">*</span></label>
                                    </td>
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="is_active" id="is_active"
                                                value="1" {{ $edit->is_active == 1 ? 'checked' : '' }}>
                                            <label class="form-check-label" for="is_active">
                                                Active
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="is_active" id="is_active"
                                                value="0" {{ $edit->is_active == 1 ? 'checked' : '' }}>
                                            <label class="form-check-label" for="is_active">
                                                Draft
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                            </table>

                            <div class="mb-3">
                                @if ($edit->product_photo)
                                    <img src="{{ asset('storage/' . $edit->product_photo) }}" alt="" width="100">
                                @else
                                    <img src="{{ asset('storage/' . $edit->product_photo) }}" alt="" width="100">
                                @endif
                                <label class="mb-3" for="">Upload Image </label>
                                <input type="file" class="form-control" name="product_photo" id=""
                                    placeholder="Enter Category Name">
                            </div>

                            <div class="mb-3">
                                <label class="mb-3" for="">Description</label>
                                <textarea class="form-control" placeholder="Address" name="product_description" style="height: 100px;">{{ $edit->product_description }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label class="mb-3" for="">Stock <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" name="stock" id=""
                                    placeholder="Enter Stock" value="{{ $edit->stock }}">
                            </div>

                            <div class="mb-3">
                                <button class="btn btn-dark" type="submit">Save</button>
                                <button class="btn btn-danger" type="reset">Cancel</button>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
