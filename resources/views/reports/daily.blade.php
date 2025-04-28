  {{-- Daily Sales Report --}}
  @extends('layouts.main')
  @section('title', 'Daily Sales Report')
  @section('content')
      <section>
          <div class="row">
              <div class="col-lg-12">
                  <div class="card-header d-flex justify-content-between align-items-center">
                      <h3 class="card-title mb-0">Daily Sales Report</h3>
                      <div>
                          <form method="GET" action="{{ route('reports.daily') }}" class="d-flex">
                              <input type="date" name="date" class="form-control me-2"
                                  value="{{ $selectedDate ?? date('Y-m-d') }}">
                              <button type="submit" class="btn btn-primary me-2">Filter</button>
                              <a href="{{ route('daily.print', ['date' => $selectedDate ?? date('Y-m-d')]) }}"
                                  class="btn btn-dark"><i class="bi bi-printer"></i></a>
                          </form>
                      </div>
                  </div>

                  <div class="card mt-3">
                      <div class="card-body">
                          <div class="row mb-4">
                              <div class="col-md-4">
                                  <div class="card bg-primary text-white">
                                      <div class="card-body">
                                          <h5 class="card-title">Total Sales</h5>
                                          <h3 class="card-text">{{ number_format($totalSales) }}</h3>
                                      </div>
                                  </div>
                              </div>
                              <div class="col-md-4">
                                  <div class="card bg-success text-white">
                                      <div class="card-body">
                                          <h5 class="card-title">Total Orders</h5>
                                          <h3 class="card-text">{{ $totalOrders }}</h3>
                                      </div>
                                  </div>
                              </div>
                              <div class="col-md-4">
                                  <div class="card bg-info text-white">
                                      <div class="card-body">
                                          <h5 class="card-title">Average Order Value</h5>
                                          <h3 class="card-text">
                                              {{ $totalOrders > 0 ? number_format($totalSales / $totalOrders) : 0 }}</h3>
                                      </div>
                                  </div>
                              </div>
                          </div>

                          <h5 class="card-title">Orders for {{ $selectedDate ?? date('Y-m-d') }}</h5>
                          <table class="table datatable table-hover">
                              <thead>
                                  <tr>
                                      <th>No</th>
                                      <th>Order Code</th>
                                      <th>Time</th>
                                      <th>Products</th>
                                      <th>Amount</th>
                                      <th>Status</th>

                                  </tr>
                              </thead>
                              <tbody>
                                  @forelse ($orders as $key => $order)
                                      <tr>
                                          <td>{{ $key + 1 }}</td>
                                          <td>{{ $order->order_code }}</td>
                                          <td>{{ date('H:i', strtotime($order->created_at)) }}</td>
                                          <td>{{ $order->orderDetails->count() }}</td>
                                          <td>{{ number_format($order->order_amount) }}</td>
                                          <td>
                                              @if ($order->order_status == 0)
                                                  <span class="badge bg-warning">Pending</span>
                                              @elseif($order->order_status == 1)
                                                  <span class="badge bg-success">Completed</span>
                                              @else
                                                  <span class="badge bg-danger">Cancelled</span>
                                              @endif
                                          </td>

                                      </tr>
                                  @empty
                                      <tr>
                                          <td colspan="7" class="text-center">No orders found for this date</td>
                                      </tr>
                                  @endforelse
                              </tbody>
                          </table>
                      </div>
                  </div>

              </div>
          </div>
      </section>
  @endsection
