@extends('layouts.main')
@section('title', 'Add New User')
@section('content')

<section class="section">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">New User</h5>

                    <form action="{{ route('users.store') }}" method="POST">
                        @csrf

                        {{-- Name --}}
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Enter user name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Enter email" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Password --}}
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Enter password" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Role / Level --}}
                        <div class="mb-3">
                            <label for="level_id" class="form-label">Level Name</label>
                            <select name="level_id" class="form-select @error('level_id') is-invalid @enderror" required>
                                <option value="">-- Select Role --</option>
                                @foreach ($Role as $level)
                                    <option value="{{ $level->id }}" {{ old('level_id') == $level->id ? 'selected' : '' }}>
                                        {{ $level->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('level_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Buttons --}}
                        <div class="mb-3">
                            <button type="submit" class="btn btn-dark">Save</button>
                            <button type="reset" class="btn btn-danger">Cancel</button>
                            {{-- <a href="{{ url()->previous() }}" class="btn btn-link">Back</a> --}}
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</section>

@endsection
