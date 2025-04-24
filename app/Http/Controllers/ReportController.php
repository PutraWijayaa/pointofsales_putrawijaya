<?php

namespace App\Http\Controllers;

use App\Models\Orders;
use App\Models\OrderDetails;
use App\Models\Product;
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
    $orders = Orders::whereDate('order_date', $selectedDate)
                  ->with('OrderDetails.product')
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
// Weekly Report
public function weeklyReport(Request $request)
{
    // Default to current week if not selected
    $selectedWeek = $request->week ?? date('Y-W');

    // Split year and week from YYYY-WW format
    [$year, $week] = explode('-', $selectedWeek);

    // Get start and end dates of the week based on ISO (Monday - Sunday)
    $weekStart = Carbon::now()->setISODate($year, $week)->startOfWeek()->format('Y-m-d');
    $weekEnd = Carbon::now()->setISODate($year, $week)->endOfWeek()->format('Y-m-d');

    // Daily sales breakdown
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

    // Calculate total sales and order count
    $totalSales = $dailySales->sum('total_sales') ?? 0;
    $totalOrders = $dailySales->sum('order_count') ?? 0;

    // Calculate total items sold this week
    $totalItems = DB::table('order_details')
        ->join('orders', 'order_details.order_id', '=', 'orders.id')
        ->whereBetween('orders.order_date', [$weekStart, $weekEnd])
        ->sum('order_details.qty') ?? 0;

    // Get top selling products this week
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

    // Get available weeks for selection
    $availableWeeks = DB::table('orders')
        ->select(
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
    $selectedMonth = $request->month ?? date('Y-m');
    list($year, $month) = explode('-', $selectedMonth);

    $monthStart = Carbon::createFromDate($year, $month, 1)->format('Y-m-d');
    $monthEnd = Carbon::createFromDate($year, $month, 1)->endOfMonth()->format('Y-m-d');

    // Get daily breakdown for the month
    $dailySales = DB::table('Orders')
    ->select(
        DB::raw('WEEK(order_date, 1) AS week_number'),
        DB::raw('MIN(order_date) AS start_date'),
        DB::raw('MAX(order_date) AS end_date'),
        DB::raw("CONCAT(YEAR(order_date), '-', WEEK(order_date, 1)) AS year_week"),
        DB::raw('COUNT(*) AS order_count'),
        DB::raw('SUM(order_amount) AS total_sales')
    )
    ->whereYear('order_date', 2025)
    ->whereMonth('order_date', 4)
    ->groupBy(DB::raw('WEEK(order_date, 1)'), DB::raw("CONCAT(YEAR(order_date), '-', WEEK(order_date, 1))"))
    ->orderBy('week_number')
    ->get();

    // Calculate totals
    $totalSales = $dailySales->sum('total_sales');
    $totalOrders = $dailySales->sum('order_count');

    // Get total items sold
    $totalItems = DB::table('order_details')
        ->join('Orders', 'order_details.order_id', '=', 'Orders.id')
        ->whereYear('Orders.order_date', $year)
        ->whereMonth('Orders.order_date', $month)
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

    // Get top selling products for the month
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
        ->whereYear('Orders.order_date', $year)
        ->whereMonth('Orders.order_date', $month)
        ->groupBy('products.id', 'products.product_name', 'categories.category_name')
        ->orderBy('total_qty', 'desc')
        ->limit(10)
        ->get();

    // Get sales by category
    $categorySales = DB::table('order_details')
        ->join('orders', 'order_details.order_id', '=', 'Orders.id')
        ->join('products', 'order_details.product_id', '=', 'products.id')
        ->join('categories', 'products.category_id', '=', 'categories.id')
        ->select(
            'categories.id',
            'categories.category_name',
            DB::raw('COUNT(DISTINCT products.id) as product_count'),
            DB::raw('SUM(order_details.qty) as total_qty'),
            DB::raw('SUM(order_details.order_subtotal) as total_amount')
        )
        ->whereYear('Orders.order_date', $year)
        ->whereMonth('Orders.order_date', $month)
        ->groupBy('categories.id', 'categories.category_name')
        ->orderBy('total_amount', 'desc')
        ->get();

    return view('reports.monthly', compact(
        'dailySales',
        'totalSales',
        'totalOrders',
        'totalItems',
        'weeklySales',
        'topProducts',
        'categorySales',
        'selectedMonth'
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
}
