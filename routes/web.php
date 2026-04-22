<?php

use App\Http\Controllers\Admin\BookController;
use App\Http\Controllers\Admin\BookItemController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ClassroomController;
use App\Http\Controllers\Admin\DamagedbookController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ExportController;
use App\Http\Controllers\Admin\SubcategoryController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BorrowController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LandingController::class, 'landing'])->name('user.landing');
// AUTHENTICATION
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ADMIN
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // Routes Crud User
    Route::resource('users', UserController::class);

    // Routes Crud Classroom
    Route::resource('classrooms', ClassroomController::class);

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

    // Routes Transaksi Management
    Route::get('/borrows', [BorrowController::class, 'index'])
        ->name('borrows.index');

    Route::get('/borrows/{borrow}', [BorrowController::class, 'show'])
        ->name('borrows.show');

    Route::patch('/borrows/{borrow}/due-date', [BorrowController::class, 'updateDueDate'])
        ->name('borrows.updateDueDate');

    Route::post('/borrows/{borrow}/approve', [BorrowController::class, 'approve'])
        ->name('borrows.approve');

    Route::post('/borrows/{borrow}/reject', [BorrowController::class, 'reject'])
        ->name('borrows.reject');

    Route::post('/borrows/{borrow}/process-return', [BorrowController::class, 'processReturn'])
        ->name('borrows.processReturn');

    Route::post('/borrows/{borrow}/return',[BorrowController::class, 'processReturn']
    )->name('borrows.return');

    Route::patch('/admin/fines/{fine}/pay', [BorrowController::class, 'pay'])
        ->name('fines.pay');

    // Routes Crud Damaged Book
    Route::resource('damaged-books', DamagedbookController::class)
        ->only(['index', 'show', 'create', 'store', 'destroy']);

    // Routes Export
    Route::get('/export/borrows', [ExportController::class, 'exportBorrow'])
        ->name('export.borrow');
});

Route::middleware(['auth'])->group(function () {

    // User Home
    Route::get('/home', [HomeController::class, 'index'])
        ->name('user.home');

    // Routes Profile
    Route::get('/profile', [ProfileController::class, 'index'])->name('user.profile');

    Route::get('/profile/password', [ProfileController::class, 'editPassword'])->name('user.password.edit');

    Route::post('/profile/password', [ProfileController::class, 'updatePassword'])->name('user.password.update');

    // Routes Book
    Route::get('/books/{book}', function (\App\Models\Book $book) {
        return view('user.books.show', compact('book'));
    })->name('books.show');

    // Routes Borrow Transaction
    Route::get('/borrows/create/', [BorrowController::class, 'create'])
        ->name('borrows.create');

    Route::get('/borrows/create/{book}', [BorrowController::class, 'createSingleBook'])
        ->name('borrows.create.singleBook');

    Route::post('/borrows', [BorrowController::class, 'store'])
        ->name('borrows.store');

    Route::get('/borrows/history', [BorrowController::class, 'history'])
        ->name('borrows.history');

    Route::get('/borrows/history/{borrow}', [BorrowController::class, 'historyShow'])
        ->name('borrows.history.show');

    Route::post('/borrow-details/{detail}/request-return', [BorrowController::class, 'requestReturn'])
        ->name('user.borrow.requestReturn');

    Route::post('/notifications/read-all', [NotificationController::class, 'markAllRead'])
        ->name('notifications.readAll');
});
