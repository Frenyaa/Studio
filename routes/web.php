<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

// Về chúng tôi (gộp: dịch vụ, giới thiệu, quy trình, đối tác, cảm nhận KH, blog)
Route::get('/ve-chung-toi', [AboutController::class, 'index'])->name('about');

// Liên hệ (trang riêng, để menu bấm ở đâu cũng vào đúng)
Route::get('/lien-he', [ContactController::class, 'index'])->name('contact');

// Dự án (công trình thiết kế)
Route::get('/du-an', [ProjectController::class, 'index'])->name('projects.index');
Route::get('/du-an/{project}', [ProjectController::class, 'show'])->name('projects.show');

// Sản phẩm (bán lẻ)
Route::get('/san-pham', [ProductController::class, 'index'])->name('products.index');
Route::get('/san-pham/{product}', [ProductController::class, 'show'])->name('products.show');

// Blog
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{post}', [BlogController::class, 'show'])->name('blog.show');

// Trang nội dung / Chính sách
Route::get('/trang/{page}', [PageController::class, 'show'])->name('pages.show');

// Form đăng ký tư vấn (AJAX) — giới hạn chống spam
Route::post('/lien-he', [LeadController::class, 'store'])
    ->middleware('throttle:10,1')
    ->name('leads.store');
