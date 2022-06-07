<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\HelperController;
use App\Http\Controllers\S3Controller;
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

Route::get('collection/collect', [CollectionController::class, 'collect']);
Route::get('collection/extending-collection', [CollectionController::class, 'extendingCollection']);
Route::get('collection/all', [CollectionController::class, 'collectionAll']);
Route::get('collection/avg', [CollectionController::class, 'collectionAvg']);
Route::get('collection/chunk', [CollectionController::class, 'collectionChunk']);
Route::get('collection/chunk-view', [CollectionController::class, 'collectionChunkView']);
Route::get('collection/collapse', [CollectionController::class, 'collectionCollapse']);
Route::get('collection/combine', [CollectionController::class, 'collectionCombine']);
Route::get('collection/concat', [CollectionController::class, 'collectionConcat']);
Route::get('collection/contains', [CollectionController::class, 'collectionContains']);
Route::get('collection/contains-2', [CollectionController::class, 'collectionContains2']);
Route::get('collection/count', [CollectionController::class, 'collectionCount']);
Route::get('collection/count-by', [CollectionController::class, 'collectionCountBy']);
Route::get('collection/count-by-2', [CollectionController::class, 'collectionCountBy2']);
Route::get('collection/cross-join', [CollectionController::class, 'collectionCrossJoin']);
Route::get('collection/cross-join-2', [CollectionController::class, 'collectionCrossJoin2']);
Route::get('collection/diff', [CollectionController::class, 'collectionDiff']);
Route::get('collection/diff-assoc', [CollectionController::class, 'collectionDiffAsoc']);
Route::get('collection/diff-keys', [CollectionController::class, 'collectionDiffKeys']);
Route::get('collection/doesnt-contains', [CollectionController::class, 'collectionDoesntContains']);
Route::get('collection/duplicates', [CollectionController::class, 'collectionDuplicates']);
Route::get('collection/each', [CollectionController::class, 'collectionEach']);
Route::get('collection/except', [CollectionController::class, 'collectionExcept']);
Route::get('collection/filter', [CollectionController::class, 'collectionFilter']);
Route::get('collection/filter-products', [CollectionController::class, 'collectionFilterProducts']);
Route::get('collection/first', [CollectionController::class, 'collectionFirst']);
Route::get('collection/forget', [CollectionController::class, 'collectionForget']);
Route::get('collection/get', [CollectionController::class, 'collectionGet']);
Route::get('collection/has', [CollectionController::class, 'collectionHas']);
Route::get('collection/implode', [CollectionController::class, 'collectionImplode']);
Route::get('collection/intersect', [CollectionController::class, 'collectionIntersect']);
Route::get('collection/intersect-key', [CollectionController::class, 'collectionIntersectKey']);

Route::get('helper/array', [HelperController::class, 'arrayHelper']);
Route::get('helper/path', [HelperController::class, 'pathHelper']);
Route::get('helper/strings', [HelperController::class, 'stringsHelper']);
Route::get('helper/urls', [HelperController::class, 'urlsHelper'])->name('app.helper.urls');
Route::get('helper/others', [HelperController::class, 'othersHelper']);

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
Route::get('orders/send-email/{order}', [OrderController::class, 'sendOrderDataViaEmail']);
Route::get('orders/send-order-shipped-email/{order}', [OrderController::class, 'sendOrderShippedEmail']);
Route::get('orders/send-order-status/{order}', [OrderController::class, 'sendOrderStatus']);

Route::get('awards', [\App\Http\Controllers\AwardController::class, 'index'])->name('award.index');
Route::get('user-blogs', [\App\Http\Controllers\AwardController::class, 'userBlogs'])->name('award.user_blogs');
Route::get('user-roles', [\App\Http\Controllers\AwardController::class, 'userRoles'])->name('award.user_roles');
Route::get('comments', [\App\Http\Controllers\AwardController::class, 'comments']);

Route::get('users/roles', [\App\Http\Controllers\UserRoleController::class, 'index']);

Route::get('file/put', [FileController::class, 'createFileWithPut']);
Route::get('file/get', [FileController::class, 'getFileContent']);
Route::get('file/download', [FileController::class, 'downloadFile']);
Route::get('file/meta', [FileController::class, 'getMeta']);
Route::get('file/prepend_append', [FileController::class, 'prependAppendFile']);
Route::get('file/copy_move', [FileController::class, 'copyMoveFile']);
Route::get('file/save_uniq_id', [FileController::class, 'saveWithUniqId']);
Route::get('file/delete', [FileController::class, 'deleteFile']);
Route::get('file/files_directories', [FileController::class, 'getFilesAndDirectories']);

Route::get('file/s3/put', [S3Controller::class, 'createFileWithPut']);
Route::get('file/s3/get', [S3Controller::class, 'getFileContent']);
Route::get('file/s3/download', [S3Controller::class, 'downloadFile']);
Route::get('file/s3/temporary_url', [S3Controller::class, 'temporaryUrl']);
Route::get('file/s3/visibility_file', [S3Controller::class, 'visibilityFile']);

