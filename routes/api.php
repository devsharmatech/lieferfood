<?php

use App\Http\Controllers\api\AuthenticationController;
use App\Http\Controllers\api\cartController;
use App\Http\Controllers\api\CustomerController;
use App\Http\Controllers\api\ShopApiController;
use App\Http\Controllers\api\OrderApiController;
use App\Http\Controllers\api\FavoriteController;
use App\Http\Controllers\api\WinOrderController;
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Route;




Route::controller(AuthenticationController::class)->prefix('v1/vendor/')->group(function () {
    Route::post('get-information', 'getInformation');

});
Route::controller(AuthenticationController::class)->prefix('v1/auth/')->group(function () {
    Route::post('login', 'login')->middleware('throttle:5,1');
    Route::post('signup', 'register')->middleware('throttle:5,1');
    Route::post('forget-password', 'forgetPassword');
    Route::post('change-password', 'changePassword');
});
Route::middleware(['throttle:winorder'])->group(function () {
    Route::get('/winorder', [WinOrderController::class, 'orders']);
    Route::post('/winorder', [WinOrderController::class, 'updateStatus']);
});
Route::controller(CustomerController::class)->prefix('v1/customer/')->group(function () {
    Route::post('update-profile-picture', 'updateProfilePicture');
    Route::post('customer-details', 'getCustomerDetail');
    Route::post('/update/customer-info', 'updateCustomerInfo');
    Route::post('/create/customer-address', 'createAddress');
});
Route::controller(ShopApiController::class)->prefix('v1/shop/')->group(function () {
    Route::post('/all', 'allVendors');
    Route::post('/view', 'viewRestaurant');
    Route::post('/view/foods', 'viewDeals');
});
Route::controller(FavoriteController::class)->prefix('v1/favorite/')->group(function () {
    Route::post('/add-in-favorite', 'addFavorite');
    Route::post('/get-favorites', 'getFavoritesRestaurants');
});
Route::controller(cartController::class)->prefix('v1/cart/')->group(function () {
    Route::post('/add-to-cart', 'store');
    Route::post('/get-cart', 'getCart');
    Route::post('/update-cart-quantity', 'updateQty');
    Route::post('/get-cart-item-detail', 'getCartProductDetail');
});
Route::controller(OrderApiController::class)->prefix('v1/order/')->group(function () {
    Route::get('/all-my-orders', 'getMyOrderWinOrder')->name('winorder.api');
});
Route::controller(OrderApiController::class)->prefix('v1/feedback/')->group(function () {
    Route::post('/get-my-feedback', 'getReview')->name('getReview.api');
    Route::post('/add-my-feedback', 'storeReview')->name('storeReview.api');
});
Route::controller(NotificationController::class)->prefix('v1/notification')->group(function () {
    Route::post('list', 'getNotifications')->name('notification-list-get');
    Route::post('read', 'markNotificationRead')->name('notification-read');
    Route::post('notification-unread-count', 'getUnreadCount')->name('notification-unread-count');
    Route::post('delete', 'deleteNotification')->name('notification-delete');
    Route::post('clear', 'clearAllNotifications')->name('notification-clear');
    Route::post('test-notification', 'testNotification');
    Route::post('update-device/token', 'updateToken')->name('update-device');
});
