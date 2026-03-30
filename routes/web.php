<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BorrowController;
use App\Http\Controllers\Admin\BookController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\BookItemController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\SubcategoryController;

Route::get('/', function () {
    return view('user.home');
})->name('user.home');

// AUTHENTICATION
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->name('password.request');

Route::post('/forgot-password', [AuthController::class, 'sendOtp'])->name('forgot-password.send-otp');

Route::get('/verify-otp', function () {
    return view('auth.verify-otp');
})->name('auth.verify-otp');

Route::post('/verify-otp', [AuthController::class, 'verifyOtp'])->name('auth.verify-otp.submit');

Route::get('/new-password', function () {
    return view('auth.new-password');
})->name('auth.new-password');

Route::post('/new-password', [AuthController::class, 'updatePassword'])->name('auth.new-password.submit');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ADMIN
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    // List And Delete User
    Route::resource('users', UserController::class)
        ->only(['index', 'create', 'store', 'destroy']);

    // Routes Crud Category
    Route::resource('categories', CategoryController::class);

    // Routes Crud Subcategory
    Route::resource('subcategories', SubcategoryController::class);

    // Routes Crud Book
    Route::resource('books', BookController::class);

    // Routes Crud Book Item
    Route::post('books/{book}/items', [BookItemController::class, 'store'])
        ->name('books.items.store');

    Route::put('books/{book}/items/{item}', [BookItemController::class, 'update'])
        ->name('books.items.update');

    Route::delete('books/{book}/items/{item}', [BookItemController::class, 'destroy'])
        ->name('books.items.destroy');

    // Routes Borrow Management
    Route::get('/borrows', [BorrowController::class, 'index'])
        ->name('borrows.index');

    Route::get('/borrows/{borrow}', [BorrowController::class, 'show'])
        ->name('borrows.show');

    Route::post('/borrows/{borrow}/return',[BorrowController::class, 'processReturn']
    )->name('borrows.return');

    Route::patch('/admin/fines/{fine}/pay', [BorrowController::class, 'pay'])
        ->name('fines.pay');
});

Route::middleware(['auth'])->group(function () {

    Route::get('/borrows/create', [BorrowController::class, 'create'])
        ->name('borrows.create');

    Route::post('/borrows', [BorrowController::class, 'store'])
        ->name('borrows.store');

    Route::get('/borrows/history', [BorrowController::class, 'history'])
        ->name('borrows.history');

    Route::get('/borrows/history/{borrow}', [BorrowController::class, 'historyShow'])
        ->name('borrows.history.show');
});
