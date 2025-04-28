@extends('layouts.main')
@section('title', 'Role Access')

@section('content')
<section class="section">
    <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ $title ?? '' }}</h5>
                    <div class="mt-4 mb-3">
                        <div align="right" class="mb-3">
                            <a href="{{ route('roles.create') }}" class="btn btn-dark"><span class="bi bi-plus"></span>
                                Add Data</a>
                        </div>
                        <table class="table datatable table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Status Aktif</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>

                                @php $no=1; @endphp
                                @foreach ($datas as $index => $data)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $data->name }}</td>
                                    <td>{{ $data->is_active ? 'Aktif' : 'Tidak Aktif' }}</td>
                                    <td>
                                        <a href="{{ route('roles.edit', $data->id) }}" class="btn btn-dark"><i
                                                class="bi bi-pencil"></i></a>

                                        <a href="{{ route('roles.destroy', $data->id) }}" class="btn btn-danger"
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
