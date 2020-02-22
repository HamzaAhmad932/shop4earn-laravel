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


Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();

    Route::get('genealogy-tree', 'Voyager\GenealogyController@index')->name('genealogy-tree');
});


Route::group(['prefix'=> 'v1'], function(){

    // New Customer Registration related Routes
    Route::post('save-customer', 'Admin\CustomerController@saveCustomer')->name('save_customer');
    Route::post('save-installment', 'Api\InstallmentController@saveInstallment')->name('save_installment');
    Route::post('get-available-sponsors-and-products', 'Admin\CustomerController@getAvailableSponsorsAndProducts')->name('get_available_sponsors_and_products');
    Route::post('get-available-products', 'Api\CustomerController@getAvailableProducts')->name('get_available_products');
    Route::post('fetch-product-price/{product_id}', 'Api\CustomerController@fetchProductPrice')->name('fetch_product_price');

    // Customer List Related Routes
    Route::post('fetch-all-customer', 'Api\CustomerController@fetchAllCustomer')->name('fetch_all_customer');

    // Installment Paying related Rotes
    Route::post('get-lease-sale-detail-to-pay', 'Api\CustomerController@getLeaseSaleDetailToPay')->name('get_lease_sale_detail_to_pay');
    Route::post('pay-lease-sale-detail', 'Api\CustomerController@payLeaseSaleDetail')->name('pay_lease_sale_detail');

    Route::get('get-genealogy-tree', 'Admin\GenealogyController@getGenealogyTree');


});



Route::get('/sales-bonus-job', function () {
    App\Jobs\SalesBonusCalculateJob::dispatchNow();
    echo "Job Dispatched";
});
