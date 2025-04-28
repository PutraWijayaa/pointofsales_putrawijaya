<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\Orders;
use App\Models\Products;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Redirect to the appropriate dashboard based on user role.
     */
    public function index()
    {
        $user = auth()->user();

        if ($user->hasRole('Admin')) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->hasRole('Kasir')) {
            return redirect()->route('kasir.dashboard');
        } elseif ($user->hasRole('Pimpinan')) {
            return redirect()->route('pimpinan.dashboard');
        }

        return redirect()->route('login');
    }

     public function admin()
     {
         // Fetching the necessary data for the dashboard
         $totalProducts = Products::count(); // Ensure the model name is correct
         $totalCategories = Categories::count(); // Ensure the model name is correct
         $totalUsers = User::count();
         $totalOrders = Orders::count();

         $datas = Products::with('category')->get();
         // Fetching recent orders
         $recentOrders = Orders::orderBy('created_at', 'desc')->take(5)->get();

         // Fetching popular products dynamically
         $popularProducts = Products::with('category')
            ->selectRaw('products.*, IFNULL(SUM(orders.order_amount), 0) as total_sales')
            ->leftJoin('orders', 'products.id', '=', 'orders.id')
            ->groupBy('products.id')
            ->orderByDesc('total_sales')
            ->take(5)
            ->get();


         // Fetching low stock products (assuming you have a 'stock' field)
        //  $lowStockProducts = Products::with('category')
        //      ->where('stock', '<=', 5)
        //      ->get();

         // Passing data to the view
         return view('admin.dashboard', [
             'totalProducts' => $totalProducts,
             'totalCategories' => $totalCategories,
             'totalUsers' => $totalUsers,
             'totalOrders' => $totalOrders,
             'recentOrders' => $recentOrders,
             'popularProducts' => $popularProducts,
            //  'lowStockProducts' => $lowStockProducts,
         ]);
     }

     public function kasir()
    {

        return view('kasir.dashboard'); // Pastikan view ini ada
    }

     public function pimpinan()
    {

        // Fetching the necessary data for the dashboard
        $totalProducts = Products::count();
        $totalCategories = Categories::count();
        $totalUsers = User::count();
        $totalOrders = Orders::count();

        $datas = Products::with('category')->get();
        // Fetching recent orders
        $recentOrders = Orders::orderBy('created_at', 'desc')->take(5)->get();

        // Fetching popular products dynamically
        $popularProducts = Products::with('category')
            ->selectRaw('products.*, IFNULL(SUM(orders.order_amount), 0) as total_sales')
            ->leftJoin('orders', 'products.id', '=', 'orders.id')
            ->groupBy('products.id')
            ->orderByDesc('total_sales')
            ->take(5)
            ->get();

        // Passing data to the view
        return view('pimpinan.dashboard', [
            'totalProducts' => $totalProducts,
            'totalCategories' => $totalCategories,
            'totalUsers' => $totalUsers,
            'totalOrders' => $totalOrders,
            'recentOrders' => $recentOrders,
            'popularProducts' => $popularProducts,
           //  'lowStockProducts' => $lowStockProducts,
        ]);
    }
    // public function pimpinan()
    // {
    //     // Daily sales chart (last 7 days)
    //     $dailySales = Transaction::where('status', 'Completed')
    //         ->whereBetween('created_at', [now()->subDays(6)->startOfDay(), now()->endOfDay()])
    //         ->select(
    //             DB::raw('DATE(created_at) as date'),
    //             DB::raw('SUM(final_price) as total')
    //         )
    //         ->groupBy('date')
    //         ->orderBy('date')
    //         ->get();

    //     // Monthly sales chart (last 6 months)
    //     $monthlySales = Transaction::where('status', 'Completed')
    //         ->whereBetween('created_at', [now()->subMonths(5)->startOfMonth(), now()->endOfMonth()])
    //         ->select(
    //             DB::raw('YEAR(created_at) as year'),
    //             DB::raw('MONTH(created_at) as month'),
    //             DB::raw('SUM(final_price) as total')
    //         )
    //         ->groupBy('year', 'month')
    //         ->orderBy('year')
    //         ->orderBy('month')
    //         ->get();

    //     // Top selling products
    //     $topProducts = DB::table('order_details')
    //         ->join('products', 'order_details.product_id', '=', 'products.id')
    //         ->join('orders', 'order_details.transaction_id', '=', 'orders.id')
    //         ->where('orders.status', 'Completed')
    //         ->select(
    //             'products.product_name',
    //             DB::raw('SUM(order_details.quantity) as quantity'),
    //             DB::raw('SUM(order_details.subtotal) as revenue')
    //         )
    //         ->groupBy('products.id', 'products.product_name')
    //         ->orderByDesc('quantity')
    //         ->limit(5)
    //         ->get();

    //     // Total revenue (current month)
    //     $currentMonthRevenue = Transaction::where('status', 'Completed')
    //         ->whereYear('created_at', now()->year)
    //         ->whereMonth('created_at', now()->month)
    //         ->sum('final_price');

    //     // Total revenue (previous month)
    //     $previousMonthRevenue = Transaction::where('status', 'Completed')
    //         ->whereYear('created_at', now()->subMonth()->year)
    //         ->whereMonth('created_at', now()->subMonth()->month)
    //         ->sum('final_price');

    //     // Revenue percentage change
    //     $percentageChange = 0;
    //     if ($previousMonthRevenue > 0) {
    //         $percentageChange = (($currentMonthRevenue - $previousMonthRevenue) / $previousMonthRevenue) * 100;
    //     }

    //     return view('dashboard.pimpinan', compact(
    //         'dailySales',
    //         'monthlySales',
    //         'topProducts',
    //         'currentMonthRevenue',
    //         'previousMonthRevenue',
    //         'percentageChange',
    //     ));
    // }
}
