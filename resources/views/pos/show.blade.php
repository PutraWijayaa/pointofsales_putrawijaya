@extends('layouts.main')
@section('title', 'Point Of Sale')
@section('content')
    <section>

        <div class="row">
            <!-- <div class="col-lg-12"> -->
                <div class="d-flex justify-content-end">
                    <div class="mb-3">
                        <!-- <a href="{{ url()->previous() }}" class="btn btn-danger">Back</a> -->
                        <a href="{{ route('print', $order->id) }}" class="btn btn-dark"><i class="bi bi-printer"></i> Print</a>
                    </div>
                </div>


                <div class="card col-lg-12">
                    <div class="mt-3">
                        <div class="card-body">
                            <!-- <h5 align="center" class="card-title">Order</h5> -->
                            <h5 class="card-title mb-0">{{ $title ?? '' }}</h5>
                            <table class="table">
                                <tr>
                                    <th>Order Code</th>
                                    <td>{{ $order->order_code ?? '' }}</td>
                                </tr>
                                <tr>
                                    <th>Order Date</th>
                                    <td>{{ $order->order_date ?? '' }}</td>
                                </tr>
                                <tr>
                                    <th>Order Status</th>
                                    <td>{{ $order->order_status ?? '' }}</td>
                                </tr>


                            </table>

                        </div>
                    </div>



                    <!-- <div class="col-lg-8"> -->
                        <!-- <div class="card"> -->
                            <div class="card-body">
                                <h5 class="card-title">Order Basket</h5>
                                <table class="table table-hover">
                                    <thead align="center">
                                        <tr>
                                            <th>No</th>
                                            <th>Photo</th>
                                            <th>Product</th>
                                            <th>Qty</th>
                                            <th>Price</th>
                                            <th>Sub Total</th>
                                            {{-- <th>Action</th> --}}
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($orderDetails as $key => $orderDetails)
                                            <tr>
                                                <td>{{ $key += 1 }}</td>
                                                <td><img src="{{ asset('storage/' . $orderDetails->product->product_photo) }}"
                                                        alt="" width="100"></td>
                                                <td>{{ $orderDetails->product->product_name }}</td>
                                                <td>{{ $orderDetails->qty }}</td>
                                                <td>{{ number_format($orderDetails->order_price) }}</td>
                                                <td>{{ number_format($orderDetails->order_subtotal) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tbody align="center">
                                    <tfoot>
                                        <!-- <tr>
                                                                    <td colspan="2">
                                                                        <input type="number" class="form-control">
                                                                    </td> -->
                                        <tr>
                                            <td colspan="3">Grand Total</td>
                                            <td colspan="3" class="text-end pe-4">
                                                <span class="grandtotal">{{ number_format($order->order_amount) }}</span>
                                            </td>
                                        </tr>
                                    </tfoot>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    <!-- </div> -->
                <!-- </div> -->







            <!-- </div> -->
        </div>
        </div>
    </section>
@endsection
