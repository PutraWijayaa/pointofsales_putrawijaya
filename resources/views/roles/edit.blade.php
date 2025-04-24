@extends('layouts.main')
@section('title', 'Add New Categories')
@section('content')


<section class="section">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">
                        Edit Data Category
                    </h5>

                    <form action="{{ route('roles.update', $edit->id)}}" method="post">
                        @csrf
                        @method('put')

                        <div class="mb-3">
                            <label class="mb-3" for="">Name </label>
                            <input type="text" class="form-control" name="name" id="" placeholder="Enter Category Name"
                                value="{{$edit->name}}" required>
                        </div>

                        <div class="mb-3">
                            <label for="is_active" class="form-label">Status</label>
                            <select name="is_active" class="form-select" required>
                                <option value="1" {{ isset($edit) && $edit->is_active == 1 ? 'selected' : '' }}>Active
                                </option>
                                <option value="0" {{ isset($edit) && $edit->is_active == 0 ? 'selected' : '' }}>Inactive
                                </option>
                            </select>
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
