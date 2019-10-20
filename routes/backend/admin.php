<?php

use App\Http\Controllers\Backend\DashboardController;
use \App\Http\Controllers\Backend\WebStatusController;

// All route names are prefixed with 'admin.'.
Route::redirect('/', '/admin/dashboard', 301);
Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::group(["prefix" => "/web-status/{user}"], function () {
    Route::get('/', [WebStatusController::class, 'index'])->name('webstatus.index');
});

