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

Route::middleware('guest')->group(function () {
    Route::get('login', [\App\Http\Controllers\AuthController::class, 'show'])->name('login');
    Route::post('login', [\App\Http\Controllers\AuthController::class, 'auth'])->name('auth');
});

Route::middleware([\App\Http\Middleware\RoleMiddleware::class . ':' . \App\Models\User::ROLE_USER])->group(function () {
    Route::get('profile', [\App\Http\Controllers\ProfileController::class, 'show'])->name('profile');
    Route::get('logout', \App\Http\Controllers\LogoutAction::class)->name('logout');
    Route::get('user/password-change', [\App\Http\Controllers\PasswordChangeController::class, 'show'])->name('user.password_change');
    Route::post('user/password-change', [\App\Http\Controllers\PasswordChangeController::class, 'change'])->name('user.password_change_submit');
});

Route::get('register', [\App\Http\Controllers\RegisterController::class, 'show'])->name('register.index');
Route::post('register', [\App\Http\Controllers\RegisterController::class, 'register'])->name('register');

Route::get('password-reset', [\App\Http\Controllers\PasswordRemindController::class, 'show'])->name('password_reminder.show');
Route::post('password-reset', [\App\Http\Controllers\PasswordRemindController::class, 'send'])->name('password_reminder.send');

Route::get('password-reset/{email}/{token}', [\App\Http\Controllers\PasswordRemindController::class, 'changePassword'])->name('password_reminder.change');
Route::post('password-reset/{email}/{token}', [\App\Http\Controllers\PasswordRemindController::class, 'submit'])->name('password_reminder.submit');
