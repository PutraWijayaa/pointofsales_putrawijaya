<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\OrderDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PopularProductController extends Controller
{
    public function index()
    {
        // Get popular products based on order count
        $popularProducts = OrderDetails::select('product_id', DB::raw('SUM(qty) as total_ordered'))
        ->with('product', 'product.category')
        ->groupBy('product_id')
        ->orderByDesc('total_ordered')
        // ->limit(10)
        ->get();

        return view('admin.popular-products.index', compact('popularProducts'));
    }

    public function report()
{
    // Get popular products with more details for the report
    $popularProducts = OrderDetails::select(
            'product_id',
            DB::raw('SUM(qty) as total_ordered'),
            DB::raw('SUM(order_subtotal) as total_revenue')
        )
        ->with('product', 'product.category')
        ->groupBy('product_id')
        ->orderByDesc('total_ordered')
        ->get();

    // Generate report number
    $today = now()->format('Y-m-d');

    // Contoh logika untuk menghitung jumlah laporan hari ini (ganti sesuai kebutuhan sistem kamu)
    $sequenceNumber = 1; // default
    // Kalau kamu punya model ReportLog atau sistem log lainnya, bisa ambil dari sana

    $reportNumber = 'LPP/' . now()->format('Y/m/d') . '/' . sprintf('%03d', $sequenceNumber);

    return view('admin.popular-products.report', compact('popularProducts', 'reportNumber'));
}

}
