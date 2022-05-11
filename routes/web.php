<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\Shop\CountryController;
use App\Http\Controllers\Shop\OrderController;
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

Route::get('orders/distinct_payment', [OrderController::class, 'distinctPayment']);
Route::get('orders/order_count_by_delivery_type', [OrderController::class, 'ordersCountByDeliveryType']);
Route::get('orders/order_count_by_delivery_type_having', [OrderController::class, 'ordersCountByDeliveryTypeHaving']);
Route::get('orders/products_by_price', [OrderController::class, 'productsByPrice']);
Route::get('orders/product_count_by_order', [OrderController::class, 'productCountByOrders']);
Route::get('orders/union_queries', [OrderController::class, 'unionQueries']);
Route::get('orders/orders_by_date', [OrderController::class, 'ordersByDate']);
Route::get('orders/orders_updated_at', [OrderController::class, 'ordersWhereCreatedAtLessUpdatedAt']);
Route::get('orders/logical_grouping', [OrderController::class, 'logicalGrouping']);
Route::get('orders/latest_orders', [OrderController::class, 'latestOrders']);
Route::get('orders/oldest_orders', [OrderController::class, 'oldestOrders']);
Route::get('orders/insert_country', [OrderController::class, 'insertCountry']);
Route::get('orders/update_country', [OrderController::class, 'updateCountry']);
Route::get('orders/delete_country', [OrderController::class, 'deleteCountry']);
Route::get('orders/exercise1_1', [OrderController::class, 'exercise1_1']);
Route::get('orders/exercise1_2', [OrderController::class, 'exercise1_2']);
Route::get('orders/exercise4', [OrderController::class, 'exercise4']);
Route::get('orders/exercise5', [OrderController::class, 'exercise5']);
Route::get('orders/exercise7', [OrderController::class, 'exercise7']);
Route::get('orders/exercise9', [OrderController::class, 'exercise9']);
Route::get('orders/products_data', [OrderController::class, 'productData']);
Route::resource('country', CountryController::class);
Route::resource('orders', OrderController::class);

Route::get('awards', [\App\Http\Controllers\AwardController::class, 'index'])->name('award.index');
Route::get('user-blogs', [\App\Http\Controllers\AwardController::class, 'userBlogs'])->name('award.user_blogs');
Route::get('user-roles', [\App\Http\Controllers\AwardController::class, 'userRoles'])->name('award.user_roles');
