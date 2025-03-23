<?php

use App\Http\Controllers\UserController;
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

Route::controller(App\Http\Controllers\UserController::class)->group(function () {
    Route::get('user/item-list', 'itemList');
    Route::get('user/transaction-wrapper-list', 'transactionWrapperList');
    Route::get('user/transaction-list', 'transactionList');
    Route::get('user/transaction-wrapper/create', 'CreateTransactionWrapper');
    Route::get('user/transaction-wrapper/{id}', 'transactionWrapperDetail');


    ///json response
    ///transaction list with transactionwrapperid
    Route::get('user/transaction-list/{id}', 'TransactionListWithWrapperID');
    ///transaction create
    Route::post('user/transaction/create', 'TransactionCreateAction');
});
