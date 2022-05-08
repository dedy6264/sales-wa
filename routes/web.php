<?php

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

Route::get('/', function () { return redirect()->route('dashboard'); });
Route::group(['middleware' => ['web', 'auth']], function () {
    
    Route::get('dashboard', 'DashboardController')->name('dashboard');
    
    Route::post('ajax_select/{type}', 'AjaxSelectController')->name('ajaxSelect');

	
    Route::get('client/all', 'ClientController@all')->name('client.all');
    Route::post('client/import', 'ClientController@import')->name('client.import');
    Route::resource('client', 'ClientController')
        ->parameters(['client' => 'client'])->except('create', 'edit', 'show');
        
    Route::post('message/all', 'MessageController@all')->name('message.all');
    Route::post('message/setAll/{id}', 'MessageController@setAll')->name('message.setAll');
    Route::resource('message', 'MessageController')
        ->parameters(['message' => 'message'])->except('create', 'edit', 'show');

    Route::get('send/all', 'SendController@all')->name('send.all');
    Route::post('send/send', 'SendController@send')->name('send.send');
    Route::resource('send', 'SendController')
        ->parameters(['send' => 'send'])->except('create', 'edit', 'show');

    // Route::post('topUp/check_daterange', 'TopUpController@checkDaterange')->name('topUp.check_daterange');
    // Route::post('topUp/all', 'TopUpController@all')->name('topUp.all');
    // Route::post('topUp/export_excel', 'TopUpController@exportExcel')->name('topUp.export_excel');
    // Route::post('topUp/transaction_detail', 'TopUpController@transactionDetail')->name('topUp.transaction_detail');
    // Route::resource('topUp', 'TopUpController')
    //     ->parameters(['topUp' => 'topUp'])->except('create', 'edit', 'show');
        
    // Route::post('AccountTransactionSummaries/check_daterange', 'AccountTransactionSummariesController@checkDaterange')->name('AccountTransactionSummaries.check_daterange');
    // Route::get('AccountTransactionSummaries/all', 'AccountTransactionSummariesController@all')->name('AccountTransactionSummaries.all');
    // Route::resource('AccountTransactionSummaries', 'AccountTransactionSummariesController')
    //     ->parameters(['AccountTransactionSummaries' => 'AccountTransactionSummaries'])->except('create', 'edit', 'show');
    
    // Route::prefix('accountHistoryTransaction')->group(function () {
    //     Route::post('all', 'AccountHistoryTransactionController@all')->name('accountHistoryTransaction.all');
    //     Route::post('export_excel', 'AccountHistoryTransactionController@export_excel')->name('accountHistoryTransaction.export_excel');
    // });
    // Route::resource('accountHistoryTransaction', 'AccountHistoryTransactionController')
    //     ->parameters(['accountHistoryTransaction' => 'accountHistoryTransaction'])->except('create', 'edit', 'show');


});

Auth::routes([
    'register'  => true,
    'verify'    => false,
    'reset'     => false,
    'confirm'   => false,
]);
