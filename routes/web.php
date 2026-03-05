<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::resource('photos',PhotoController::class);

Route::get('/',[HomeController::class, 'home'])->name('photos.home');
Route::get('about',[PhotoController::class, 'about'])->name('photos.about');
Route::get('contact',[PhotoController::class, 'contact'])->name('photos.contact');
Route::get('adminpanel',[PhotoController::class, 'create'])->name('admin.adminpanel');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';