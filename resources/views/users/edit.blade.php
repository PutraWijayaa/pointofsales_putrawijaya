@extends('layouts.main')
@section('title', 'Edit User')
@section('content')

<section class="section">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Edit User</h5>

                    <form action="{{ route('users.update', $edit->id) }}" method="post">
                        @csrf
                        @method('put')

                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" name="name" value="{{ old('name', $edit->name) }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" value="{{ old('email', $edit->email) }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password <small>(Isi jika ingin ganti)</small></label>
                            <input type="password" class="form-control" name="password" placeholder="Leave blank if not changing">
                        </div>

                        <div class="mb-3">
                            <label for="level_id" class="form-label">Level Name</label>
                            <select name="level_id" class="form-select @error('level_id') is-invalid @enderror" required>
                                <option value="">-- Select Role --</option>
                                @foreach ($roles as $level)
                                    <option value="{{ $level->id }}"
                                        {{ (old('level_id', $selectedRoleId) == $level->id) ? 'selected' : '' }}>
                                        {{ $level->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('level_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <button class="btn btn-dark" type="submit">Update</button>
                            <a href="{{ route('users.index') }}" class="btn btn-secondary">Back</a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</section>

@endsection
