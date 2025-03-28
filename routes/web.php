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
    Route::get('user/transaction-wrapper/create/{id}', 'CreateTransactionWrapper');
    Route::get('user/transaction-wrapper/{id}', 'transactionWrapperDetail');


    ///json response
    //update transaction wrapper
    Route::post('user/transaction-wrapper/{id}/update', 'TransactionWrapperUpdateStatusAction');
    ///transaction list with transactionwrapperid
    Route::get('user/transaction-list/{id}', 'TransactionListWithWrapperID');
    ///transaction create
    Route::post('user/transaction/create', 'TransactionCreateAction');
    //transaction increment jumlah
    Route::post('user/transaction/{id}/increment', 'TransactionIncrementAction');
    //transaction derement jumlah
    Route::post('user/transaction/{id}/decrement', 'TransactionDecrementAction');
});
