<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

// Dự án (công trình thiết kế)
Route::get('/du-an', [ProjectController::class, 'index'])->name('projects.index');
Route::get('/du-an/{project}', [ProjectController::class, 'show'])->name('projects.show');

// Sản phẩm (bán lẻ)
Route::get('/san-pham', [ProductController::class, 'index'])->name('products.index');
Route::get('/san-pham/{product}', [ProductController::class, 'show'])->name('products.show');

// Cảm hứng / Blog
Route::get('/cam-hung', [BlogController::class, 'index'])->name('blog.index');
Route::get('/cam-hung/{post}', [BlogController::class, 'show'])->name('blog.show');

// Trang nội dung / Chính sách
Route::get('/trang/{page}', [PageController::class, 'show'])->name('pages.show');

// Form đăng ký tư vấn (AJAX) — giới hạn chống spam
Route::post('/lien-he', [LeadController::class, 'store'])
    ->middleware('throttle:10,1')
    ->name('leads.store');
