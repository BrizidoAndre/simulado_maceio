<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PublicController;
use Illuminate\Support\Facades\Route;

// public routes
Route::get('/', [PublicController::class, 'index'])->name('public.index');
Route::post('/contact', [PublicController::class, 'contact'])->name('public.contact');
Route::get('/gallery', [PublicController::class, 'gallery'])->name('public.gallery');
Route::get('/posts', [PublicController::class, 'posts'])->name('public.posts');
Route::get('/posts/{post}', [PublicController::class, 'postShow'])->name('public.postShow');

//authenticated related routes
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'logon'])->name('logon');
Route::get('/logout', [AuthController::class, 'logout'])->name('auth.logout');
// authenticated routes
Route::middleware('auth')->group(function () {
    Route::prefix('/admin-panel')->group(function () {
        Route::get('', [ContactController::class, 'index'])->name('admin.index');
        Route::get('/contacts', [ContactController::class, 'index'])->name('contact.index');
//        registering resources controllers (with default methods and cruds)
        Route::resource('category', CategoryController::class);
        Route::resource('gallery', ImageController::class)->only(['index', 'create', 'store', 'destroy']);
        Route::resource('post', PostController::class);
        Route::get('post/{post}/toggle', [PostController::class, 'toggle'])->name('post.toggle');
    });
});
