<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataTransfer\OrderDataTransferController;
use App\Http\Controllers\DataTransfer\ProductDataTransferController;
use App\Http\Controllers\DataTransfer\CategoryDataTransferController;
use App\Http\Controllers\DataTransfer\UserListDataTransferController;

Route::group(['middleware' => 'auth'], function () {
    Route::prefix('admin')->group(function () {
        // export
        Route::get('/category/export', [CategoryDataTransferController::class, 'export'])->name('export.categories');
        Route::get('/product/export', [ProductDataTransferController::class, 'export'])->name('export.product');
        Route::get('/orders/export', [OrderDataTransferController::class, 'export'])->name('export.order');
        Route::get('/user/export', [UserListDataTransferController::class, 'export'])->name('export.users');

        // import
        Route::post('/category/import', [CategoryDataTransferController::class, 'import'])->name('import.categories');
        Route::post('/product/import', [ProductDataTransferController::class, 'import'])->name('import.product');

        // download
        Route::get('/category/template', [CategoryDataTransferController::class, 'download'])->name('template.categories');
        Route::get('/product/template', [ProductDataTransferController::class, 'download'])->name('template.product');
    });
});
