<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [\App\Http\Controllers\PageController::class, 'create'])->name('home');
Route::get('/recent', [\App\Http\Controllers\PageController::class, 'recent'])->name('recent');
Route::get('/trending', [\App\Http\Controllers\PageController::class, 'trending'])->name('trending');
Route::get('/search', [\App\Http\Controllers\PageController::class, 'search'])->name('search');
Route::get('/terms-of-use', [\App\Http\Controllers\PageController::class, 'terms'])->name('terms');
Route::get('/privacy-policy', [\App\Http\Controllers\PageController::class, 'policy'])->name('policy');
Route::get('/faq', [\App\Http\Controllers\PageController::class, 'faq'])->name('faq');
Route::get('/categories/{slug}', [\App\Http\Controllers\PageController::class, 'categories'])->name('categories');
Route::get('/images/{image}', [\App\Http\Controllers\PageController::class, 'image'])->name('image');

Route::middleware('admin')->prefix('/admin')->group(function(){
    Route::get('/', [\App\Http\Controllers\AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/reports', [\App\Http\Controllers\ReportController::class, 'reports'])->name('admin.reports');
    Route::delete('/post/{post}', [\App\Http\Controllers\PostController::class, 'delete'])->name('admin.delete_post');
});

Route::get('/{slug}', [\App\Http\Controllers\PageController::class, 'show'])->name('show');

Route::prefix('/auth')->group(function(){
    Route::get('/login', [\App\Http\Controllers\AuthController::class, 'login'])->name('auth.login');
    Route::post('/login', [\App\Http\Controllers\AuthController::class, 'do_login'])->name('auth.do_login');
});

Route::middleware('cors')->prefix('/cron')->group(function(){
    Route::get('/delete-posts', [\App\Http\Controllers\CronController::class, 'deletePosts']);
    Route::get('/clear-files', [\App\Http\Controllers\CronController::class, 'clearFile']);
    Route::get('/delete-ip', [\App\Http\Controllers\CronController::class, 'ipDelete']);
});


Route::post('/create_post', [\App\Http\Controllers\PostController::class, 'create'])->name('create_post');
Route::post('/report_post', [\App\Http\Controllers\ReportController::class, 'do_report'])->name('report_post');
Route::post('/allow_nsfw', [\App\Http\Controllers\AuthController::class, 'allow_nsfw'])->name('allow_nsfw');

