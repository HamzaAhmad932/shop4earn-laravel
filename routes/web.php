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

//Website Routes
Route::get('/', 'HomeController@index');
Route::get('/shop/category/{id?}', 'ProductController@index')->name('shop.category');
Route::get('/product/{id?}', 'ProductController@productDetail')->name('shop.product');
Route::get('/cart', 'CartController@index')->name('cart.show');
Route::get('/checkout', 'CheckoutController@index')->name('checkout');
Route::get('/thanks', 'HomeController@thanks')->name('thanks');

//API routes
Route::post('cart-add', 'CartController@addToCart')->name('cart.add');

//Portal Routes
Route::group(['prefix' => 'portal'], function () {

    Voyager::routes();

    Route::group(['middleware'=> 'auth'], function (){
        Route::get('/', 'Voyager\DashboardController@index')->name('voyager.dashboard');
        Route::get('genealogy-tree', 'Voyager\GenealogyController@index')->name('genealogy-tree');
        Route::get('request-payout', 'Voyager\PayoutRequestController@index')->name('request-payout');
        //for admin
        Route::get('payout-requests', 'Voyager\PayoutRequestController@adminIndex')->name('payout-requests');
        Route::get('request-payout/create', 'Voyager\PayoutRequestController@create')->name('request-payout-create');
    });
});

//API Routes
Route::group(['prefix'=> 'v1'], function(){

    // New Customer Registration related Routes
    Route::post('save-customer', 'Admin\CustomerController@saveCustomerData')->name('save_customer');
    Route::post('get-available-sponsors-and-products', 'Admin\CustomerController@getAvailableSponsorsAndProducts')->name('get_available_sponsors_and_products');
    Route::post('get-genealogy-tree', 'Admin\GenealogyController@getGenealogyTree');
    Route::post('fetch-all-payout-requests', 'Voyager\PayoutRequestController@fetchAllPayoutRequests');
    Route::get('fetch-all-payment-method', 'Voyager\PayoutRequestController@fetchAllPaymentMethod');
    Route::post('add-payout-request', 'Voyager\PayoutRequestController@addPayoutRequest');
    Route::post('update-payout-request-status', 'Voyager\PayoutRequestController@updatePayoutRequestStatus');
    Route::get('get-dashboard-data', 'Voyager\DashboardController@dashboardData');
    Route::get('get-shopping-cart-content', 'CartController@getShoppingCartContent');
    Route::post('update-shopping-cart-content', 'CartController@updateShoppingCartContent');
    Route::post('delete-shopping-cart-item', 'CartController@deleteShoppingCartItem');
    Route::post('/activate', 'Voyager\DashboardController@activateCustomer')->name('activate_user');
    Route::post('checkout', 'CheckoutController@checkout');
});

Route::get('test-team-bonus', 'Admin\CustomerController@testTeamBonus');
Route::get('rank-update', 'Admin\CustomerController@rankupdate');
Route::get('reward/{id}', 'Admin\CustomerController@giveReward');

Route::get('/give-sales-bonus/{id}', function ($id) {
    $customer = \App\Customer::where('user_id', $id)->first();
    if(!empty($customer)) {
        App\Jobs\SalesBonusCalculateJob::dispatchNow($customer);
        echo "Done";
        echo "<br>";
        echo "Sales bonus deliver to upline for Customer id: " . $id;
    }else{
        echo "Customer not found.";
    }
});
