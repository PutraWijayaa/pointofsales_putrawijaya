<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\StockHistoryController;
use App\Models\Orders;
use App\Models\OrderDetails;
use App\Models\Products;
use App\Models\StockHistory;
use App\Models\Categories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportController extends Controller
{
    // daily report
    public function dailyReport(Request $request)
    {
        $selectedDate = $request->date ?? date('Y-m-d');

        // Get orders for the selected date
        $orders = Orders::with(['orderDetails' => function($query) {
            $query->select('id', 'order_id', 'product_id', 'qty', 'order_price', 'order_subtotal');
        }])
        ->with(['orderDetails.product' => function($query) {
            $query->select('id', 'product_name');
        }])
        ->whereDate('order_date', $selectedDate)
        ->orderBy('created_at')
        ->get();

        // Calculate total sales
        $totalSales = $orders->sum('order_amount');
        $totalOrders = $orders->count();

        // Get top selling products for the day
        $topProducts = DB::table('order_details')
            ->join('orders', 'order_details.order_id', '=', 'orders.id')
            ->join('products', 'order_details.product_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->select(
                'products.id',
                'products.product_name',
                'categories.category_name',
                DB::raw('SUM(order_details.qty) as total_qty'),
                DB::raw('SUM(order_details.order_subtotal) as total_amount')
            )
            ->whereDate('orders.order_date', $selectedDate)
            ->groupBy('products.id', 'products.product_name', 'categories.category_name')
            ->orderBy('total_qty', 'desc')
            ->limit(5)
            ->get();

        return view('reports.daily', compact(
            'orders',
            'totalSales',
            'totalOrders',
            'topProducts',
            'selectedDate'
        ));
    }

    public function printDailyReport(Request $request)
    {
        // Similar to dailyReport but with a print view
        $selectedDate = $request->date ?? date('Y-m-d');

        // Get Orders for the selected date
        $Orders = Orders::whereDate('order_date', $selectedDate)
            ->with('OrderDetails.product')
            ->get();

        // Calculate total sales
        $totalSales = $Orders->sum('order_amount');
        $totalOrders = $Orders->count();

        // Get top selling products for the day
        $topProducts = DB::table('order_details')
            ->join('Orders', 'order_details.order_id', '=', 'Orders.id')
            ->join('products', 'order_details.product_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->select(
                'products.id',
                'products.product_name',
                'categories.category_name',
                DB::raw('SUM(order_details.qty) as total_qty'),
                DB::raw('SUM(order_details.order_subtotal) as total_amount')
            )
            ->whereDate('Orders.order_date', $selectedDate)
            ->groupBy('products.id', 'products.product_name', 'categories.category_name')
            ->orderBy('total_qty', 'desc')
            ->limit(5)
            ->get();

        return view('reports.print.daily', compact(
            'Orders',
            'totalSales',
            'totalOrders',
            'topProducts',
            'selectedDate'
        ));
    }

    // Weekly Report
    // public function weeklyReport(Request $request)
    // {
    //     $selectedWeek = $request->input('week', date('Y') . '-' . str_pad(date('W'), 2, '0', STR_PAD_LEFT));
    //     [$year, $week] = explode('-', $selectedWeek);

    //     if (!is_numeric($year) || !is_numeric($week)) {
    //         return back()->with('error', 'Format minggu tidak valid. Contoh: 2025-12');
    //     }

    //     $weekStart = Carbon::now()->setISODate((int)$year, (int)$week)->startOfWeek()->format('Y-m-d');
    //     $weekEnd = Carbon::now()->setISODate((int)$year, (int)$week)->endOfWeek()->format('Y-m-d');

    //     $dailySales = DB::table('orders')
    //         ->select(
    //             DB::raw('DATE(order_date) as date'),
    //             DB::raw('COUNT(*) as order_count'),
    //             DB::raw('SUM(order_amount) as total_sales')
    //         )
    //         ->whereBetween('order_date', [$weekStart, $weekEnd])
    //         ->groupBy(DB::raw('DATE(order_date)'))
    //         ->orderBy('date')
    //         ->get();

    //     $totalSales = $dailySales->sum('total_sales') ?? 0;
    //     $totalOrders = $dailySales->sum('order_count') ?? 0;

    //     $totalItems = DB::table('order_details')
    //         ->join('orders', 'order_details.order_id', '=', 'orders.id')
    //         ->whereBetween('orders.order_date', [$weekStart, $weekEnd])
    //         ->sum('order_details.qty') ?? 0;

    //     $topProducts = DB::table('order_details')
    //         ->join('orders', 'order_details.order_id', '=', 'orders.id')
    //         ->join('products', 'order_details.product_id', '=', 'products.id')
    //         ->join('categories', 'products.category_id', '=', 'categories.id')
    //         ->select(
    //             'products.id',
    //             'products.product_name',
    //             'categories.category_name',
    //             DB::raw('SUM(order_details.qty) as total_qty'),
    //             DB::raw('SUM(order_details.order_subtotal) as total_amount')
    //         )
    //         ->whereBetween('orders.order_date', [$weekStart, $weekEnd])
    //         ->groupBy('products.id', 'products.product_name', 'categories.category_name')
    //         ->orderByDesc('total_qty')
    //         ->limit(10)
    //         ->get();

    //     $availableWeeks = DB::table('orders')
    //         ->select(
    //             DB::raw('YEAR(order_date) as year'),
    //             DB::raw('WEEK(order_date, 1) as week_number'),
    //             DB::raw("CONCAT(YEAR(order_date), '-', LPAD(WEEK(order_date, 1), 2, '0')) as year_week"),
    //             DB::raw('MIN(order_date) as start_date'),
    //             DB::raw('MAX(order_date) as end_date'),
    //             DB::raw('COUNT(*) as order_count'),
    //             DB::raw('SUM(order_amount) as total_sales')
    //         )
    //         ->groupBy('year', 'week_number', 'year_week')
    //         ->orderByDesc('year')
    //         ->orderByDesc('week_number')
    //         ->get();

    //     return view('reports.weekly', compact(
    //         'dailySales',
    //         'weekStart',
    //         'weekEnd',
    //         'totalSales',
    //         'totalOrders',
    //         'totalItems',
    //         'topProducts',
    //         'selectedWeek',
    //         'availableWeeks'
    //     ));
    // }

    public function weeklyReport(Request $request)
    {
        $selectedWeek = str_replace('W', '', $request->input('week', date('Y') . '-' . date('W')));

        if (!preg_match('/^\d{4}-\d{2}$/', $selectedWeek)) {
            $selectedWeek = date('Y') . '-' . date('W');
        }

        [$year, $week] = explode('-', $selectedWeek);

        $weekStart = Carbon::now()->setISODate($year, $week)->startOfWeek()->toDateString();
        $weekEnd = Carbon::now()->setISODate($year, $week)->endOfWeek()->toDateString();

        $dailySales = Orders::select(
                DB::raw('DATE(order_date) as date'),
                DB::raw('COUNT(*) as order_count'),
                DB::raw('SUM(order_amount) as total_sales')
            )
            ->whereBetween('order_date', [$weekStart, $weekEnd])
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $totalSales = $dailySales->sum('total_sales') ?? 0;
        $totalOrders = $dailySales->sum('order_count') ?? 0;

        $totalItems = OrderDetails::whereHas('order', function($query) use ($weekStart, $weekEnd) {
                $query->whereBetween('order_date', [$weekStart, $weekEnd]);
            })
            ->sum('qty') ?? 0;

        $topProducts = OrderDetails::with(['product.category', 'order'])
        ->select(
            'product_id',
            DB::raw('SUM(qty) as total_qty'),
            DB::raw('SUM(order_subtotal) as total_amount')
        )
        ->whereHas('order', function($query) use ($weekStart, $weekEnd) {
            $query->whereBetween('order_date', [$weekStart, $weekEnd]);
        })
        ->groupBy('product_id')
        ->orderByDesc('total_qty')
        ->limit(10)
        ->get()
        ->map(function($item) {
            return (object)[
                'product_name' => $item->product->product_name,
                'category_name' => $item->product->category->category_name,
                'total_qty' => $item->total_qty,
                'total_amount' => $item->total_amount
            ];
        });

        $availableWeeks = Orders::select(
                DB::raw('YEAR(order_date) as year'),
                DB::raw('WEEK(order_date, 1) as week_number'),
                DB::raw("CONCAT(YEAR(order_date), '-', LPAD(WEEK(order_date, 1), 2, '0')) as year_week"),
                DB::raw('MIN(order_date) as start_date'),
                DB::raw('MAX(order_date) as end_date'),
                DB::raw('COUNT(*) as order_count'),
                DB::raw('SUM(order_amount) as total_sales')
            )
            ->groupBy('year', 'week_number', 'year_week')
            ->orderByDesc('year')
            ->orderByDesc('week_number')
            ->get();

        return view('reports.weekly', compact(
            'dailySales',
            'weekStart',
            'weekEnd',
            'totalSales',
            'totalOrders',
            'totalItems',
            'topProducts',
            'selectedWeek',
            'availableWeeks'
        ));
    }

    public function printWeeklyReport(Request $request)
    {
        // Default to current week if not selected
        $selectedWeek = $request->week ?? date('Y-W');

        // Split year and week from YYYY-WW format
        [$year, $week] = explode('-', $selectedWeek);

        // Get start and end dates of the week based on ISO (Monday - Sunday)
        $weekStart = Carbon::now()->setISODate($year, $week)->startOfWeek()->format('Y-m-d');
        $weekEnd = Carbon::now()->setISODate($year, $week)->endOfWeek()->format('Y-m-d');

        // Daily sales breakdown (same query as weeklyReport)
        $dailySales = DB::table('orders')
            ->select(
                DB::raw('DATE(order_date) as date'),
                DB::raw('COUNT(*) as order_count'),
                DB::raw('SUM(order_amount) as total_sales')
            )
            ->whereBetween('order_date', [$weekStart, $weekEnd])
            ->groupBy(DB::raw('DATE(order_date)'))
            ->orderBy('date')
            ->get();

        // Calculate totals
        $totalSales = $dailySales->sum('total_sales') ?? 0;
        $totalOrders = $dailySales->sum('order_count') ?? 0;

        // Calculate total items
        $totalItems = DB::table('order_details')
            ->join('orders', 'order_details.order_id', '=', 'orders.id')
            ->whereBetween('orders.order_date', [$weekStart, $weekEnd])
            ->sum('order_details.qty') ?? 0;

        // Get top selling products
        $topProducts = DB::table('order_details')
            ->join('orders', 'order_details.order_id', '=', 'orders.id')
            ->join('products', 'order_details.product_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->select(
                'products.id',
                'products.product_name',
                'categories.category_name',
                DB::raw('SUM(order_details.qty) as total_qty'),
                DB::raw('SUM(order_details.order_subtotal) as total_amount')
            )
            ->whereBetween('orders.order_date', [$weekStart, $weekEnd])
            ->groupBy('products.id', 'products.product_name', 'categories.category_name')
            ->orderByDesc('total_qty')
            ->limit(10)
            ->get();

        return view('reports.print.weekly', compact(
            'dailySales',
            'weekStart',
            'weekEnd',
            'totalSales',
            'totalOrders',
            'totalItems',
            'topProducts',
            'selectedWeek'
        ));
    }

    // Monthly Report
    public function monthlyReport(Request $request)
    {
        // Ambil bulan yang dipilih atau bulan saat ini
        $selectedMonth = $request->input('month', date('Y-m'));
        $startDate = Carbon::parse($selectedMonth)->startOfMonth();
        $endDate = Carbon::parse($selectedMonth)->endOfMonth();

        // Data penjualan harian
        $dailySales = DB::table('orders')
            ->select(
                DB::raw('DATE(order_date) as date'),
                DB::raw('SUM(order_amount) as total_sales'),
                DB::raw('COUNT(*) as order_count')
            )
            ->whereBetween('order_date', [$startDate, $endDate])
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Data penjualan mingguan
        $weeklySales = DB::table('orders')
            ->select(
                DB::raw('WEEK(order_date, 1) as week_number'),
                DB::raw('CONCAT(YEAR(order_date), "-W", LPAD(WEEK(order_date, 1), 2, "0")) as year_week'),
                DB::raw('MIN(DATE(order_date)) as start_date'),
                DB::raw('MAX(DATE(order_date)) as end_date'),
                DB::raw('SUM(order_amount) as total_sales'),
                DB::raw('COUNT(*) as order_count')
            )
            ->whereBetween('order_date', [$startDate, $endDate])
            ->groupBy('week_number', 'year_week')
            ->orderBy('week_number')
            ->get();

        // Produk terlaris
        $topProducts = DB::table('order_details')
            ->join('orders', 'order_details.order_id', '=', 'orders.id')
            ->join('products', 'order_details.product_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->select(
                'products.id',
                'products.product_name',
                'categories.category_name',
                DB::raw('SUM(order_details.qty) as total_qty'),
                DB::raw('SUM(order_details.order_subtotal) as total_amount')
            )
            ->whereBetween('orders.order_date', [$startDate, $endDate])
            ->groupBy('products.id', 'products.product_name', 'categories.category_name')
            ->orderByDesc('total_amount')
            ->limit(10)
            ->get();

        // Penjualan per kategori
        $categorySales = DB::table('order_details')
            ->join('orders', 'order_details.order_id', '=', 'orders.id')
            ->join('products', 'order_details.product_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->select(
                'categories.id',
                'categories.category_name',
                DB::raw('COUNT(DISTINCT products.id) as product_count'),
                DB::raw('SUM(order_details.qty) as total_qty'),
                DB::raw('SUM(order_details.order_subtotal) as total_amount')
            )
            ->whereBetween('orders.order_date', [$startDate, $endDate])
            ->groupBy('categories.id', 'categories.category_name')
            ->orderByDesc('total_amount')
            ->get();

        // Total keseluruhan
        $totalSales = $dailySales->sum('total_sales');
        $totalOrders = $dailySales->sum('order_count');
        $totalItems = DB::table('order_details')
            ->join('orders', 'order_details.order_id', '=', 'orders.id')
            ->whereBetween('orders.order_date', [$startDate, $endDate])
            ->sum('qty');

        return view('reports.monthly', compact(
            'selectedMonth',
            'dailySales',
            'weeklySales',
            'topProducts',
            'categorySales',
            'totalSales',
            'totalOrders',
            'totalItems',
            'startDate',
            'endDate'
        ));
    }

    public function printMonthlyReport(Request $request)
    {
        $selectedMonth = $request->month ?? date('Y-m');
        list($year, $month) = explode('-', $selectedMonth);

        $monthStart = Carbon::createFromDate($year, $month, 1)->format('Y-m-d');
        $monthEnd = Carbon::createFromDate($year, $month, 1)->endOfMonth()->format('Y-m-d');

        $dailySales = DB::table('orders')
            ->select(
                DB::raw('DATE(order_date) as date'),
                DB::raw('COUNT(*) as order_count'),
                DB::raw('SUM(order_amount) as total_sales')
            )
            ->whereYear('order_date', $year)
            ->whereMonth('order_date', $month)
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $totalSales = $dailySales->sum('total_sales');
        $totalOrders = $dailySales->sum('order_count');

        $totalItems = DB::table('order_details')
            ->join('orders', 'order_details.order_id', '=', 'orders.id')
            ->whereYear('orders.order_date', $year)
            ->whereMonth('orders.order_date', $month)
            ->sum('qty');

        $weeklySales = DB::select("
        SELECT
        WEEK(order_date, 1) AS week_number,
        MIN(order_date) AS start_date,
        MAX(order_date) AS end_date,
        CONCAT(YEAR(order_date), '-', WEEK(order_date, 1)) AS year_week,
        COUNT(*) AS order_count,
        SUM(order_amount) AS total_sales
    FROM Orders
    WHERE YEAR(order_date) = ? AND MONTH(order_date) = ?
    GROUP BY WEEK(order_date, 1), year_week
    ORDER BY week_number;
    ", [$year, $month]);

        $topProducts = DB::table('order_details')
            ->join('orders', 'order_details.order_id', '=', 'orders.id')
            ->join('products', 'order_details.product_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->select(
                'products.id',
                'products.product_name',
                'categories.category_name',
                DB::raw('SUM(order_details.qty) as total_qty'),
                DB::raw('SUM(order_details.order_subtotal) as total_amount')
            )
            ->whereYear('orders.order_date', $year)
            ->whereMonth('orders.order_date', $month)
            ->groupBy('products.id', 'products.product_name', 'categories.category_name')
            ->orderBy('total_qty', 'desc')
            ->limit(10)
            ->get();

        $categorySales = DB::table('order_details')
            ->join('orders', 'order_details.order_id', '=', 'orders.id')
            ->join('products', 'order_details.product_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->select(
                'categories.id',
                'categories.category_name',
                DB::raw('COUNT(DISTINCT products.id) as product_count'),
                DB::raw('SUM(order_details.qty) as total_qty'),
                DB::raw('SUM(order_details.order_subtotal) as total_amount')
            )
            ->whereYear('orders.order_date', $year)
            ->whereMonth('orders.order_date', $month)
            ->groupBy('categories.id', 'categories.category_name')
            ->orderBy('total_amount', 'desc')
            ->get();

        return view('reports.print.monthly', compact(
            'dailySales',
            'totalSales',
            'totalOrders',
            'totalItems',
            'weeklySales',
            'topProducts',
            'categorySales',
            'selectedMonth',
            'monthStart',
            'monthEnd'
        ));
    }

    // Yearly Report
    public function yearlyReport(Request $request)
    {
        $selectedYear = $request->year ?? date('Y');

        // Get monthly breakdown for the year
        $monthlySales = DB::table('Orders')
            ->select(
                DB::raw('MONTH(order_date) as month'),
                DB::raw('DATE_FORMAT(order_date, "%M") as month_name'),
                DB::raw('COUNT(*) as order_count'),
                DB::raw('SUM(order_amount) as total_sales')
            )
            ->whereYear('order_date', $selectedYear)
            ->groupBy('month', 'month_name')
            ->orderBy('month')
            ->get();

        // Calculate totals
        $totalSales = $monthlySales->sum('total_sales');
        $totalOrders = $monthlySales->sum('order_count');

        // Get total items sold for the year
        $totalItems = DB::table('order_details')
            ->join('Orders', 'order_details.order_id', '=', 'Orders.id')
            ->whereYear('Orders.order_date', $selectedYear)
            ->sum('qty');

        // Get quarterly breakdown
        $quarterlySales = DB::select("
        SELECT
            QUARTER(order_date) as quarter,
            MIN(order_date) as start_date,
            MAX(order_date) as end_date,
            COUNT(*) as order_count,
            SUM(order_amount) as total_sales
        FROM Orders
        WHERE YEAR(order_date) = ?
        GROUP BY QUARTER(order_date)
        Orders BY quarter
    ", [$selectedYear]);

        // Get top selling products for the year
        $topProducts = DB::table('order_details')
            ->join('Orders', 'order_details.order_id', '=', 'Orders.id')
            ->join('products', 'order_details.product_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->select(
                'products.id',
                'products.product_name',
                'categories.category_name',
                DB::raw('SUM(order_details.qty) as total_qty'),
                DB::raw('SUM(order_details.order_subtotal) as total_amount')
            )
            ->whereYear('Orders.order_date', $selectedYear)
            ->groupBy('products.id', 'products.product_name', 'categories.category_name')
            ->orderBy('total_qty', 'desc')
            ->limit(10)
            ->get();

        // Get sales by category for the year
        $categorySales = DB::table('order_details')
            ->join('Orders', 'order_details.order_id', '=', 'Orders.id')
            ->join('products', 'order_details.product_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->select(
                'categories.id',
                'categories.category_name',
                DB::raw('COUNT(DISTINCT products.id) as product_count'),
                DB::raw('SUM(order_details.qty) as total_qty'),
                DB::raw('SUM(order_details.order_subtotal) as total_amount')
            )
            ->whereYear('Orders.order_date', $selectedYear)
            ->groupBy('categories.id', 'categories.category_name')
            ->orderBy('total_amount', 'desc')
            ->get();

        return view('reports.yearly', compact(
            'monthlySales',
            'totalSales',
            'totalOrders',
            'totalItems',
            'quarterlySales',
            'topProducts',
            'categorySales',
            'selectedYear'
        ));
    }

    public function printYearlyReport(Request $request)
    {
        $selectedYear = $request->year ?? date('Y');

        // Same queries as yearlyReport method
        $monthlySales = DB::table('Orders')
            ->select(
                DB::raw('MONTH(order_date) as month'),
                DB::raw('DATE_FORMAT(order_date, "%M") as month_name'),
                DB::raw('COUNT(*) as order_count'),
                DB::raw('SUM(order_amount) as total_sales')
            )
            ->whereYear('order_date', $selectedYear)
            ->groupBy('month', 'month_name')
            ->orderBy('month')
            ->get();

        $totalSales = $monthlySales->sum('total_sales');
        $totalOrders = $monthlySales->sum('order_count');

        $totalItems = DB::table('order_details')
            ->join('Orders', 'order_details.order_id', '=', 'Orders.id')
            ->whereYear('Orders.order_date', $selectedYear)
            ->sum('qty');

        $quarterlySales = DB::select("
        SELECT
            QUARTER(order_date) as quarter,
            MIN(order_date) as start_date,
            MAX(order_date) as end_date,
            COUNT(*) as order_count,
            SUM(order_amount) as total_sales
        FROM Orders
        WHERE YEAR(order_date) = ?
        GROUP BY QUARTER(order_date)
        Orders BY quarter
    ", [$selectedYear]);

        $topProducts = DB::table('order_details')
            ->join('Orders', 'order_details.order_id', '=', 'Orders.id')
            ->join('products', 'order_details.product_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->select(
                'products.id',
                'products.product_name',
                'categories.category_name',
                DB::raw('SUM(order_details.qty) as total_qty'),
                DB::raw('SUM(order_details.order_subtotal) as total_amount')
            )
            ->whereYear('Orders.order_date', $selectedYear)
            ->groupBy('products.id', 'products.product_name', 'categories.category_name')
            ->orderBy('total_qty', 'desc')
            ->limit(10)
            ->get();

        $categorySales = DB::table('order_details')
            ->join('Orders', 'order_details.order_id', '=', 'Orders.id')
            ->join('products', 'order_details.product_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->select(
                'categories.id',
                'categories.category_name',
                DB::raw('COUNT(DISTINCT products.id) as product_count'),
                DB::raw('SUM(order_details.qty) as total_qty'),
                DB::raw('SUM(order_details.order_subtotal) as total_amount')
            )
            ->whereYear('Orders.order_date', $selectedYear)
            ->groupBy('categories.id', 'categories.category_name')
            ->orderBy('total_amount', 'desc')
            ->get();

        return view('reports.print.yearly', compact(
            'monthlySales',
            'totalSales',
            'totalOrders',
            'totalItems',
            'quarterlySales',
            'topProducts',
            'categorySales',
            'selectedYear'
        ));
    }

    public function laporan_stokbarang()
    {
        $products = Products::orderBy('product_name')->get();
        return view('stock.index', compact('products'));
    }

    public function stockHistory()
    {
        $stockHistories = StockHistory::with('product')->orderByDesc('created_at')->get();

        return view('reports.stock_history', compact('stockHistories'));
    }

    public function stockReport()
    {
        $products = Products::all();

        return view('reports.stock', compact('products'));
    }

    public function print()
    {
        //  data produk
        $products = Products::all();

        //  view laporan stok produk untuk cetak
        return view('reports.print.report_stock_print', compact('products'));
    }

    public function printHistory()
    {
        $stockHistories = StockHistory::with('product')
            ->orderBy('created_at', 'desc')
            ->get();

            $stockHistories = StockHistory::with('product')->get();

        return Pdf::loadView('reports.print.stockHis', [
            'stockHistories' => $stockHistories
        ])->stream('laporan-stok.pdf');

    }

}
