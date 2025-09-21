<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TikTokAuthController;
use App\Http\Controllers\Dashboard\PostController;
use App\Http\Controllers\Dashboard\LeadController;
use App\Http\Controllers\SolutionController;


Route::view('/', 'landing')->name('home');
Route::view('/terms', 'terms')->name('terms');
Route::view('/privacy', 'privacy')->name('privacy');
Route::get('/solutions/{slug}', [SolutionController::class, 'show'])->name('solutions.show');
Route::get('/solutions', [SolutionController::class, 'index'])->name('solutions.index');

Route::post('/leads/js/store', [LeadController::class, 'jsStore'])->name('leads.js.store');

Auth::routes();
Route::middleware(['auth',/*'verified','can:isAdmin'*/])->group(function () {
    Route::get('/dashboard', function () { return view('dashboard.dashboard'); })->name('dashboard');

    Route::get('/dashboard/posts', [PostController::class,'index'])->name('posts.index');
    Route::get('/dashboard/posts/create', [PostController::class,'create'])->name('posts.create');
    Route::post('/dashboard/posts', [PostController::class,'store'])->name('posts.store');
    Route::post('/dashboard/posts/{post}/publish-now', [PostController::class,'publishNow'])->name('posts.publishNow');
    Route::get('/dashboard/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::put('/dashboard/posts/{post}', [PostController::class, 'update'])->name('posts.update');
    Route::delete('/dashboard/posts/{post}/delete', [PostController::class, 'destroy'])->name('posts.destroy');
        
    Route::resource('/dashboard/leads', LeadController::class);

    Route::get('/tiktok/connect', [TikTokAuthController::class,'redirect'])->name('tiktok.connect');
});

Route::get('/tiktok/callback', [TikTokAuthController::class,'callback'])->name('tiktok.callback');

require __DIR__.'/auth.php';