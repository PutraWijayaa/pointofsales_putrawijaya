@extends('layouts.main')
@section('title', 'Data Order')

@section('content')
<section class="section">
    <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ $title ?? '' }}</h5>
                    <div class="mt-4 mb-3">
                        <div align="right" class="mb-3">
                            <a href="{{ route('pos.create') }}" class="btn btn-dark" target="_blank"><span
                                    class="bi bi-plus-circle"></span>
                                Sales</a>
                        </div>
                        <table class="table datatable table-hover">
                            <thead class="text-center">
                                <tr>
                                    <th>No</th>
                                    <th>Order Code</th>
                                    <th>Order Date</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                @php $no=1; @endphp
                                @foreach ($datas as $index => $data)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $data->order_code }}</td>
                                    <td>{{ \Carbon\Carbon::parse($data->order_date)->translatedFormat('d F Y') }}</td>
                                    <td>{{ $data->order_amount }}</td>
                                    <td class="text-center">
                                        @switch($data->order_status)
                                        @case(0)
                                        <span class="badge bg-secondary">Pending</span>
                                        @break

                                        @case(1)
                                        <span class="badge bg-success">Complete</span>
                                        @break

                                        @case(2)
                                        <span class="badge bg-danger">Cancelled</span>
                                        @break

                                        @default
                                        <span class="badge bg-dark">Unknown</span>
                                        @endswitch
                                    </td>

                                    <td class="text-center">
                                        <a href="{{ route('pos.show', $data->id) }}" class="btn btn-danger"><i
                                                class="bi bi-eye"></i></a>

                                        <a href="{{ route('print', $data->id) }}" class="btn btn-dark"><i
                                                class="bi bi-printer"></i></a>

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
