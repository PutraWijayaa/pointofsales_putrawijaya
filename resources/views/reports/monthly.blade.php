{{-- Monthly Sales Report --}}
@extends('layouts.main')
@section('content')
<section>
    <div class="row">
        <div class="col-lg-12">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title mb-0">Monthly Sales Report</h3>
                <div>
                    <form method="GET" action="{{ route('reports.monthly') }}" class="d-flex">
                        <div class="input-group me-2">
                            <span class="input-group-text">Month</span>
                            <input type="month" name="month" class="form-control" value="{{ $selectedMonth ?? date('Y-m') }}">
                        </div>
                        <button type="submit" class="btn btn-primary me-2">Filter</button>
                        <a href="{{ route('reports.monthly.print', ['month' => $selectedMonth ?? date('Y-m')]) }}" class="btn btn-dark"><i class="bi bi-printer"></i></a>
                    </form>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="card bg-primary text-white">
                                <div class="card-body">
                                    <h5 class="card-title">Monthly Sales</h5>
                                    <h3 class="card-text">{{ number_format($totalSales) }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-success text-white">
                                <div class="card-body">
                                    <h5 class="card-title">Monthly Orders</h5>
                                    <h3 class="card-text">{{ $totalOrders }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-info text-white">
                                <div class="card-body">
                                    <h5 class="card-title">Avg Order Value</h5>
                                    <h3 class="card-text">{{ $totalOrders > 0 ? number_format($totalSales / $totalOrders) : 0 }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-warning text-white">
                                <div class="card-body">
                                    <h5 class="card-title">Items Sold</h5>
                                    <h3 class="card-text">{{ $totalItems }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-8">
                            <h5 class="card-title">Daily Sales Trend</h5>
                            <div class="chart-container" style="height: 300px;">
                                <canvas id="monthlySalesChart"></canvas>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <h5 class="card-title">Sales by Category</h5>
                            <div class="chart-container" style="height: 300px;">
                                <canvas id="categorySalesChart"></canvas>
                            </div>
                        </div>
                    </div>

                    <h5 class="card-title mt-4">Weekly Breakdown</h5>
                    <table class="table datatable table-hover table-striped">
                        <thead class="table-dark" align="center">
                            <tr>
                                <th>Week</th>
                                <th>Period</th>
                                <th>Orders</th>
                                <th>Sales</th>
                                <th>% of Month</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($weeklySales as $weekly)
                                <tr>
                                    <td>Week {{ $weekly->week_number }}</td>
                                    <td>{{ $weekly->start_date }} - {{ $weekly->end_date }}</td>
                                    <td>{{ $weekly->order_count }}</td>
                                    <td>{{ number_format($weekly->total_sales) }}</td>
                                    <td>{{ number_format(($weekly->total_sales / $totalSales) * 100, 1) }}%</td>
                                    <td>
                                        <a href="{{ route('reports.weekly', ['week' => $weekly->year_week]) }}" class="btn btn-sm btn-info">
                                            Details
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-body">
                    <h5 class="card-title">Top 10 Selling Products</h5>
                    <table class="table datatable table-hover table-striped">
                        <thead>
                            <tr>
                                <th>Rank</th>
                                <th>Product</th>
                                <th>Category</th>
                                <th>Quantity Sold</th>
                                <th>Amount</th>
                                <th>% of Sales</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($topProducts as $key => $product)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $product->product_name }}</td>
                                    <td>{{ $product->category_name }}</td>
                                    <td>{{ $product->total_qty }}</td>
                                    <td>{{ number_format($product->total_amount) }}</td>
                                    <td>{{ number_format(($product->total_amount / $totalSales) * 100, 1) }}%</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">No products sold this month</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-body">
                    <h5 class="card-title">Sales by Category</h5>
                    <table class="table datatable table-hover table-striped">
                        <thead>
                            <tr>
                                <th>Category</th>
                                <th>Products Sold</th>
                                <th>Quantity</th>
                                <th>Amount</th>
                                <th>% of Sales</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($categorySales as $category)
                                <tr>
                                    <td>{{ $category->category_name }}</td>
                                    <td>{{ $category->product_count }}</td>
                                    <td>{{ $category->total_qty }}</td>
                                    <td>{{ number_format($category->total_amount) }}</td>
                                    <td>{{ number_format(($category->total_amount / $totalSales) * 100, 1) }}%</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">No sales data available</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Daily sales chart
        const salesCtx = document.getElementById('monthlySalesChart').getContext('2d');
        new Chart(salesCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode($dailySales->pluck('date')) !!},
                datasets: [{
                    label: 'Daily Sales',
                    data: {!! json_encode($dailySales->pluck('total_sales')) !!},
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgb(54, 162, 235)',
                    borderWidth: 2,
                    tension: 0.1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Category sales chart
        const categoryCtx = document.getElementById('categorySalesChart').getContext('2d');
        new Chart(categoryCtx, {
            type: 'pie',
            data: {
                labels: {!! json_encode($categorySales->pluck('category_name')) !!},
                datasets: [{
                    data: {!! json_encode($categorySales->pluck('total_amount')) !!},
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.7)',
                        'rgba(54, 162, 235, 0.7)',
                        'rgba(255, 206, 86, 0.7)',
                        'rgba(75, 192, 192, 0.7)',
                        'rgba(153, 102, 255, 0.7)',
                        'rgba(255, 159, 64, 0.7)',
                        'rgba(199, 199, 199, 0.7)',
                        'rgba(83, 102, 255, 0.7)',
                        'rgba(40, 159, 64, 0.7)',
                        'rgba(210, 99, 132, 0.7)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    });
</script>
@endsection
