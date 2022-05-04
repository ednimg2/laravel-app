<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\BookController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('blogs/inactive', [BlogController::class, 'inactiveList']);

Route::get('books/autocomplete', \App\Http\Controllers\BookAutocompleteController::class)->name('books.autocomplete');
Route::get('books/{book}/download', \App\Http\Controllers\BookDownloadController::class)->name('books.download');
Route::get('books/export', \App\Http\Controllers\BookExportController::class)->name('books.export');
Route::post('cookies', \App\Http\Controllers\CookieController::class)->name('cookies');
Route::resource('books', BookController::class);
Route::resource('blogs', BlogController::class);

Route::middleware('guest')->group(function () {
    Route::get('login', [\App\Http\Controllers\AuthController::class, 'show'])->name('login');
    Route::post('login', [\App\Http\Controllers\AuthController::class, 'auth'])->name('auth');
});

Route::middleware('auth')->group(function () {
    Route::get('profile', [\App\Http\Controllers\ProfileController::class, 'show'])->name('profile');
    Route::get('logout', \App\Http\Controllers\LogoutAction::class)->name('logout');
    Route::get('user/password-change', [\App\Http\Controllers\PasswordChangeController::class, 'show'])->name('user.password_change');
    Route::post('user/password-change', [\App\Http\Controllers\PasswordChangeController::class, 'change'])->name('user.password_change_submit');
});
