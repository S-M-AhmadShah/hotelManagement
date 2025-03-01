<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DeletedOrderController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\RoomController as AdminRoomController;
use App\Http\Controllers\Admin\RoomTypeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| Register your web routes here. These routes are loaded by the
| RouteServiceProvider and assigned to the "web" middleware group.
|--------------------------------------------------------------------------
*/

Route::get('/', [PageController::class, 'index'])->name('home');
Route::get('/rooms', [PageController::class, 'list_rooms'])->name('rooms.index');
Route::post('/rooms', [PageController::class, 'search'])->name('search');
Route::get('/profile', [PageController::class, 'showProfile'])->name('profile');
Route::put('/profile', [PageController::class, 'updateProfile']);

Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');

// User Account Management
Route::get('/user', [UserController::class, 'index'])->name('user.index');
Route::get('/orders/{order}/report', [OrderController::class, 'generatePDF'])->name('orders.report');

/************************************
 *              Auth
 ************************************/
Route::controller(AuthController::class)->group(function () {
    Route::get('register', 'showRegistrationForm')->name('register');
    Route::post('register', 'register');

    Route::get('login', 'showLoginForm')->name('login');
    Route::post('login', 'login');
    Route::post('logout', 'logout')->name('logout');
});

/************************************
 *              Admin
 ************************************/
Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('index');
    Route::resource('orders', AdminOrderController::class);
    Route::resource('roomtypes', RoomTypeController::class)->except('show');
    Route::resource('rooms', AdminRoomController::class)->except('show');
    // Manage Customers
    Route::get('customers', [AdminController::class, 'customers'])->name('customers');

    // Approve Reviews
    Route::post('/reviews/{id}/approve', [ReviewController::class, 'approve'])->name('reviews.approve');
    Route::get('/reviews', [ReviewController::class, 'reviews'])->name('reviews');
    Route::resource('orders', AdminOrderController::class);
    Route::delete('/reviews/{id}', [ReviewController::class, 'destroy'])->name('reviews.delete');
});

/************************************
 *              Reviews
 ************************************/
Route::middleware('auth')->group(function () {
    //Route::get('/reviews/create', [ReviewController::class, 'showCreateForm'])->name('reviews.create'); // Adjusted route for review form
    Route::get('/reviews/create', [ReviewController::class, 'create'])->name('user.reviews.create');   // Original route for review form
    Route::post('/reviews', [ReviewController::class, 'store'])->name('user.reviews.store');           // Submit reviews
});

// Public-facing reviews
Route::post('/orders/{id}/cancel', [OrderController::class, 'cancelOrder'])->name('orders.cancel');
Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews.index');
Route::get('/download-booking-csv', [AdminController::class, 'downloadBookingCSV'])->name('download.booking.csv');
Route::get('/admin/deleted-orders', [DeletedOrderController::class, 'index'])->name('admin.deleted-orders.index');
Route::post('/reserve/pay', [PaymentController::class, 'payWithJazzCash'])->name('pay.jazzcash');
Route::get('/payment/callback', [PaymentController::class, 'paymentCallback'])->name('payment.callback');

