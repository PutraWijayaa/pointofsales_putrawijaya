@extends('layouts.main')
@section('title', 'Add New Product')
@section('content')


    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">
                            New Product
                        </h5>

                        <form action="{{ route('product.store') }}" method="post" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-3">
                                <label class="mb-3" for="">Product Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="product_name" id=""
                                    placeholder="Enter Category Name" required>
                            </div>

                            <div class="mb-3">
                                <label class="mb-3" for="">Price <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" name="product_price" id=""
                                    placeholder="Enter Category Name" required>
                            </div>

                            <div class="mb-3">
                                <label class="mb-3" for="">Category Name</label>
                                <select id="category_id" name="category_id" class="form-select">
                                    <option selected="">-- Option --</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->category_name }}</option>
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
                                                value="1" checked>
                                            <label class="form-check-label" for="is_active">
                                                Active
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="is_active" id="is_active"
                                                value="0">
                                            <label class="form-check-label" for="is_active">
                                                Draft
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                            </table>

                            {{-- <div class="row mb-3">
                                <div class="col-md-2">
                                    <div class="form-check">
                                        <label for="" style="font-weight: 900">Status <span
                                                class="text-danger">*</span></label>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="gridRadios" id="gridRadios1"
                                            value="option1" checked="">
                                        <label class="form-check-label" for="gridRadios1">
                                            Active
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="gridRadios" id="gridRadios1"
                                            value="option1" checked="">
                                        <label class="form-check-label" for="gridRadios1">
                                            Draft
                                        </label>
                                    </div>
                                </div>
                            </div> --}}


                            <div class="mb-3">
                                <label class="mb-3" for="">Upload Image </label>
                                <input type="file" class="form-control" name="product_photo" required>
                            </div>

                            <div class="mb-3">
                                <label class="mb-3" for="">Description</label>
                                <textarea class="form-control" placeholder="Address" name="product_description" style="height: 100px;"></textarea>
                            </div>


                            <div class="mb-3">
                                <button class="btn btn-dark" type="submit">Save</button>
                                <button class="btn btn-danger" type="reset">Cancel</button>
                                {{-- <a href="{{url()->previous}}" class="text-primary">Back</a> --}}
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
