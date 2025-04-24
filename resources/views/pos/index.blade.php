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
                                <a href="{{ route('pos.create') }}" class="btn btn-warning"><span
                                        class="bi bi-plus-circle"></span>
                                    Sales</a>
                            </div>
                            <table class="table table-bordered">
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
                                            <td>{{ $data->order_date }}</td>
                                            <td>{{ $data->order_amount }}</td>
                                            <td>{{ $data->order_status }}</td>

                                            <td class="text-center">
                                                <a href="{{ route('pos.show', $data->id) }}" class="btn btn-warning"><i
                                                        class="bi bi-eye"></i></a>

                                                <a href="{{ route('print', $data->id) }}" class="btn btn-dark"><i class="bi bi-printer"></i></a>

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
