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
Route::get('blogs/add-to-wishlist/{id}', [BlogController::class, 'addToWishlist']);
Route::get('blogs/wishlist', [BlogController::class, 'showWishlist']);
Route::get('blogs/delete-wishlist/{id}', [BlogController::class, 'deleteFromWishlist']);
//Route::get('/blogs/{slug}', [BlogController::class, 'edit']);

Route::get('books/autocomplete', \App\Http\Controllers\BookAutocompleteController::class)->name('books.autocomplete');
Route::get('books/{book}/download', \App\Http\Controllers\BookDownloadController::class)->name('books.download');
Route::get('books/export', \App\Http\Controllers\BookExportController::class)->name('books.export');
Route::post('cookies', \App\Http\Controllers\CookieController::class)->name('cookies');

Route::resource('books', BookController::class);
Route::resource('blogs', BlogController::class);
