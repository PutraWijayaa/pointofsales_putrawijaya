<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ReportController;
// use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PopularProductController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Route untuk halaman landing
Route::get('/', function () {
    return redirect()->route('login');
});

// Routes Autentikasi
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::get('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Route untuk halaman tidak diizinkan
Route::get('/unauthorized', function () {
    return view('unauthorized');
})->name('unauthorized');

// Routes yang dilindungi oleh middleware auth
Route::middleware('auth')->group(function () {
    // Route redirect default berdasarkan role
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Route untuk profil
    // Route::get('/profile', [ProfileController::class, 'edit'])->name('profile');
    // Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');

    // Routes untuk Admin
    Route::middleware('role:Admin')->group(function () {
        // Dashboard
        Route::get('/admin/dashboard', [DashboardController::class, 'admin'])->name('admin.dashboard');

        Route::get('/popular-products', [App\Http\Controllers\PopularProductController::class, 'index'])->name('popular-products.index');
        Route::get('/popular-products/report', [App\Http\Controllers\PopularProductController::class, 'report'])->name('popular-products.report');

        // Manajemen User
        Route::resource('users', UsersController::class);
        Route::resource('roles', RolesController::class);

        // Manajemen Kategori Produk
        Route::resource('categories', CategoriesController::class);

        // Manajemen Produk
        Route::resource('product', ProductController::class);

        Route::post('/stock/add', [ProductController::class, 'addStock'])->name('stock.add');

        // Route::post('/products/import', [ProductController::class, 'import'])->name('products.import');
        // Route::get('/products/export', [ProductController::class, 'export'])->name('products.export');

        // Produk Populer
        Route::get('/popular-products', [PopularProductController::class, 'index'])->name('popular-products.index');
        Route::get('/popular-products/export', [PopularProductController::class, 'export'])->name('popular-products.export');
    });

    // Routes untuk Kasir
    Route::middleware('role:Kasir')->group(function () {
        // Dashboard
        Route::get('/kasir/dashboard', [DashboardController::class, 'kasir'])->name('kasir.dashboard');

        // POS - Point of Sale
        Route::resource('pos', TransactionController::class);

        // Melihat stok produk
        Route::get('/stock-products', [ProductController::class, 'stockProducts'])->name('stock-products.index');

        // Transaksi Hari Ini
        Route::get('/today-transactions', [TransactionController::class, 'todayTransactions'])->name('transactions.today');
        route::get('print/{id}', [TransactionController::class, 'print'])->name('print');
    });

    // Routes untuk Pimpinan
    Route::middleware('role:Pimpinan')->group(function () {
        // Dashboard
        Route::get('/pimpinan/dashboard', [DashboardController::class, 'pimpinan'])->name('pimpinan.dashboard');

        // Laporan
        // Route::get('/stock', [ReportController::class, 'laporan_stokbarang'])->name('stock');
        // Route::post('/stock', [ReportController::class, 'laporan_stokbarang_load'])->name('stock');

        Route::get('/report', [ReportController::class, 'stockReport'])->name('stock.report');
        Route::get('/history', [ReportController::class, 'stockHistory'])->name('stock.history');
        Route::get('/stock-history/print', [ReportController::class, 'printHistory'])->name('stok.cetakHis');
        Route::get('/stok/cetak', [ReportController::class, 'print'])->name('stok.cetak');

        // Datily Reports
        Route::get('/reports/daily', [ReportController::class, 'dailyReport'])->name('reports.daily');
        Route::get('/daily', [ReportController::class, 'dailyReport'])->name('daily');
        Route::get('/daily/print', [ReportController::class, 'printDailyReport'])->name('daily.print');

        // Weekly reports
        Route::get('/reports/weekly', [ReportController::class, 'weeklyReport'])->name('reports.weekly');
        Route::get('/weekly', [ReportController::class, 'weeklyReport'])->name('weekly');
        Route::get('/weekly/print', [ReportController::class, 'printWeeklyReport'])->name('reports.weekly.print');

        // Monthly reports
        Route::get('/reports/monthly', [ReportController::class, 'monthlyReport'])->name('reports.monthly');
        Route::get('/monthly', [ReportController::class, 'monthlyReport'])->name('monthly');
        Route::get('/monthly/print', [ReportController::class, 'printMonthlyReport'])->name('reports.monthly.print');

        // Yearly reports
        // Route::get('/yearly', [ReportController::class, 'yearlyReport'])->name('yearly');
        // Route::get('/yearly/print', [ReportController::class, 'printYearlyReport'])->name('yearly.print');

    });

    // Route untuk Admin dan Pimpinan (melihat transaksi)
    Route::middleware('role:Admin,Pimpinan')->group(function () {
        Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
        Route::get('/transactions/{transaction}', [TransactionController::class, 'show'])->name('transactions.show');
    });
});
