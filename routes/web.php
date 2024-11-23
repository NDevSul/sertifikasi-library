<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\BorrowController;

Route::get('/', function () {
    return view('home');
})->name('home');
Route::resource('books', BookController::class);
Route::resource('categories', CategoryController::class);
Route::resource('members', MemberController::class);
Route::resource('BorrowedBook', MemberController::class);

Route::get('/categories/{category}/books', [CategoryController::class, 'books'])->name('categories.books');
Route::get('/categories/{category}/books', [CategoryController::class, 'showBooks'])->name('categories.books');

Route::get('borrows/create', [BorrowController::class, 'create'])->name('borrows.create');
Route::post('borrows', [BorrowController::class, 'store'])->name('borrows.store');
Route::post('borrows/{bookId}/{memberId}/return', [BorrowController::class, 'updateStatus'])->name('borrows.updateStatus');

Route::get('/borrows/create', [BorrowController::class, 'create'])->name('borrows.create');
Route::post('/borrows/{book}/{member}/status', [BorrowController::class, 'updateStatus'])->name('borrows.updateStatus');
Route::get('/members/{member}/books', [MemberController::class, 'books'])->name('members.books');
