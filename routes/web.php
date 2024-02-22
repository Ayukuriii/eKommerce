<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserListController;
use Illuminate\Support\Facades\DB;

Route::redirect('/', '/admin/dashboard');



Route::group(['middleware' => 'guest'], function () {
    Route::get('/register', [AuthController::class, 'create'])->name('auth.register');
    Route::post('/register', [AuthController::class, 'store'])->name('auth.store');
    Route::get('/login', [AuthController::class, 'index'])->name('auth.index');
    Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('/profile', [AuthController::class, 'show'])->name('auth.profile');
    Route::put('/profile', [AuthController::class, 'update'])->name('auth.profile.update');
    Route::get('/profile/edit', [AuthController::class, 'edit'])->name('auth.profile.edit');
    Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');

    Route::prefix('admin')->group(function () {
        Route::get('/dashboard', function () {
            $startDate1 = Carbon::now()->subDays(2)->startOfDay();
            $endDate1 = Carbon::now()->endOfDay();
            $orderCount = DB::table('orders')
                ->whereBetween('created_at', [$startDate1, $endDate1])
                ->count();

            $productCount = DB::table('products')->count();

            $startDate2 = Carbon::now()->subWeek()->startOfDay();
            $endDate2 = Carbon::now()->endOfDay();
            $userCount = DB::table('users')
                ->whereBetween('created_at', [$startDate2, $endDate2])
                ->count();
            return view('admin.dashboard', compact('orderCount', 'productCount', 'userCount'));
        })->name('dashboard');

        Route::get('/user', [UserListController::class, 'index'])->name('admin.user.index');
        Route::get('/user/{user}', [UserListController::class, 'show'])->name('admin.user.show');

        Route::get('/orders', [OrderController::class, 'index'])->name('admin.orders.index');
        Route::get('/orders/{order}', [OrderController::class, 'show'])->name('admin.orders.show');

        Route::resource('category', CategoryController::class);
        Route::resource('product', ProductController::class);
    });
});
