<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\PublisherController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\DetailTransactionController;




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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'dashboard'])->name('home');

/** 
Route::get('/authors', [App\Http\Controllers\AuthorController::class, 'index'])->name('author');
Route::get('/books', [App\Http\Controllers\BookController::class, 'index'])->name('book');
Route::get('/catalogs', [App\Http\Controllers\CatalogController::class, 'index'])->name('catalog');
Route::get('/publishers', [App\Http\Controllers\PublisherController::class, 'index'])->name('publisher');
Route::get('/members', [App\Http\Controllers\MemberController::class, 'index'])->name('member');
Route::get('/transactions', [App\Http\Controllers\TransactionController::class, 'index'])->name('transaction');
Route::get('/detail_transactions', [App\Http\Controllers\DetailTransactionController::class, 'index'])->name('detail_transaction');
*/
Route::resource('/catalogs', CatalogController::class);
Route::resource('/books', BookController::class);
Route::resource('/authors', AuthorController::class);
Route::resource('/publishers', PublisherController::class);
Route::resource('/members', MemberController::class);
Route::resource('/transactions', TransactionController::class);

Route::get('/api/authors', [App\Http\Controllers\AuthorController::class, 'api']);
Route::get('/api/publishers', [App\Http\Controllers\PublisherController::class, 'api']);
Route::get('/api/members', [App\Http\Controllers\MemberController::class, 'api']);
Route::get('/api/books', [App\Http\Controllers\BookController::class, 'api']);
Route::get('/api/transactions', [App\Http\Controllers\TransactionController::class, 'api']);

//Add Spatie
Route::get('/addspatie', [App\Http\Controllers\TransactionController::class, 'addspatie']);