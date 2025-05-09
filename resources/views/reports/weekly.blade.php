@extends('layouts.main')

@section('content')
<div class="container-fluid">
    <div class="row mt-4 mb-3">
        <div class="col-md-6">
            <h1 class="h3 mb-0 text-gray-800">Weekly Sales Report</h1>
        </div>
        <div class="col-md-6 text-end">
            <form action="{{ route('reports.weekly') }}" method="GET" class="d-inline-block">
                <div class="input-group">
                    <label class="input-group-text" for="week">Select Week</label>
                    <input type="week" id="week" name="week" value="{{ str_replace('-', '-W', $selectedWeek) }}"
                        class="form-control" onchange="this.form.submit()">
                </div>
            </form>
            <a href="{{ route('reports.weekly.print', ['week' => $selectedWeek]) }}" class="btn btn-secondary ms-2"
                target="_blank">
                <i class="fas fa-print"></i> Print Report
            </a>
        </div>
    </div>

    <!-- Report Summary Card -->
    <div class="card mb-4 shadow">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                Report Summary: {{ date('d M Y', strtotime($weekStart)) }} - {{ date('d M Y', strtotime($weekEnd)) }}
            </h6>
        </div>
        <div class="card-body">
            <div class="row text-center">
                <div class="col-md-4 mb-3 mb-md-0">
                    <div class="border rounded p-3 bg-light">
                        <p class="text-primary mb-1">Total Sales</p>
                        <h4 class="mb-0">{{ number_format($totalSales, 2) }}</h4>
                    </div>
                </div>
                <div class="col-md-4 mb-3 mb-md-0">
                    <div class="border rounded p-3 bg-light">
                        <p class="text-success mb-1">Total Orders</p>
                        <h4 class="mb-0">{{ $totalOrders }}</h4>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="border rounded p-3 bg-light">
                        <p class="text-info mb-1">Items Sold</p>
                        <h4 class="mb-0">{{ $totalItems }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts and Top Products -->
    <div class="row">
        <!-- Daily Sales Chart -->
        <!-- <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Daily Sales</h6>
                </div>
                <div class="card-body">
                    <canvas id="dailySalesChart" width="400" height="300"></canvas>
                </div>
            </div>
        </div> -->

        <!-- Top Selling Products -->
        <div class="col-lg-12 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Top Selling Products</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table datatable table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Product</th>
                                    <th>Category</th>
                                    <th class="text-end">Qty Sold</th>
                                    <th class="text-end">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($topProducts as $index => $product)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $product->product_name }}</td>
                                    <td>{{ $product->category_name }}</td>
                                    <td class="text-end">{{ $product->total_qty }}</td>
                                    <td class="text-end">{{ number_format($product->total_amount, 2) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Daily Sales Breakdown -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daily Sales Breakdown</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table datatable table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th class="text-end">Orders</th>
                            <th class="text-end">Sales</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($dailySales as $index => $day)
                        <tr>
                            <td>{{ date('D, d M Y', strtotime($day->date)) }}</td>
                            <td class="text-end">{{ $day->order_count }}</td>
                            <td class="text-end">{{ number_format($day->total_sales, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="fw-bold">
                        <tr>
                            <td>Total</td>
                            <td class="text-end">{{ $totalOrders }}</td>
                            <td class="text-end">{{ number_format($totalSales, 2) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
