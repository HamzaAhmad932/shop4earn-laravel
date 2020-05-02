<?php

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


Route::get('/', 'HomeController@index');
Route::get('/shop/category/{id?}', 'ProductController@index')->name('shop.category');

Route::group(['prefix' => 'portal'], function () {
    Voyager::routes();

    Route::get('/', 'Voyager\DashboardController@index')->name('voyager.dashboard');
    Route::get('genealogy-tree', 'Voyager\GenealogyController@index')->name('genealogy-tree');
    Route::get('request-payout', 'Voyager\PayoutRequestController@index')->name('request-payout');
    //for admin
    Route::get('payout-requests', 'Voyager\PayoutRequestController@adminIndex')->name('payout-requests');
    Route::get('request-payout/create', 'Voyager\PayoutRequestController@create')->name('request-payout-create');
});


Route::group(['prefix'=> 'v1'], function(){

    // New Customer Registration related Routes
    Route::post('save-customer', 'Admin\CustomerController@saveCustomer')->name('save_customer');
    Route::post('get-available-sponsors-and-products', 'Admin\CustomerController@getAvailableSponsorsAndProducts')->name('get_available_sponsors_and_products');
    Route::post('get-genealogy-tree', 'Admin\GenealogyController@getGenealogyTree');
    Route::post('fetch-all-payout-requests', 'Voyager\PayoutRequestController@fetchAllPayoutRequests');
    Route::get('fetch-all-payment-method', 'Voyager\PayoutRequestController@fetchAllPaymentMethod');
    Route::post('add-payout-request', 'Voyager\PayoutRequestController@addPayoutRequest');
    Route::post('update-payout-request-status', 'Voyager\PayoutRequestController@updatePayoutRequestStatus');
});

Route::get('test-team-bonus', 'Admin\CustomerController@testTeamBonus');
Route::get('rank-update', 'Admin\CustomerController@rankupdate');

Route::get('/sales-bonus-job', function () {
    App\Jobs\SalesBonusCalculateJob::dispatchNow();
    echo "Job Dispatched";
});
