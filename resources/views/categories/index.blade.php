@extends('layouts.main')
@section('title', 'Data Categories')

@section('content')
    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ $title ?? '' }}</h5>
                        <div class="mt-4 mb-3">
                            <div align="right" class="mb-3">
                                <a href="{{ route('categories.create') }}" class="btn btn-dark"><span
                                        class="bi bi-plus"></span> Add Data</a>
                            </div>
                            <table class="table datatable table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @php $no=1; @endphp
                                    @foreach ($datas as $index => $data)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $data->category_name }}</td>
                                            <td>
                                                <a href="{{ route('categories.edit', $data->id) }}" class="btn btn-dark"><i
                                                        class="bi bi-pencil"></i></a>

                                                <a href="{{ route('categories.destroy', $data->id) }}"
                                                    class="btn btn-danger" data-confirm-delete="true"><i
                                                        class="bi bi-trash"></i></a>

                                                {{-- <form class="d-inline" action="{{route('categories.destroy', $data->id)}}" method="post">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn btn-danger">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form> --}}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>

            </div>

            {{-- <div class="col-lg-6">

      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Example Card</h5>
          <p>This is an examle page with no contrnt. You can use it as a starter for your custom pages.</p>
        </div>
      </div>

    </div> --}}

        </div>
    </section>

@endsection
