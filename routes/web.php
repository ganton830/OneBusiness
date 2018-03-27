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

Route::resource('stocktransfer', 'StocktransferController', ['middleware' => 'auth']);

Route::get('{item}/tmasterDetail', 'StocktransferController@tmasterDetail')->name('tmaster.details');

Route::get('{item}/tmasterOriginalDetail', 'StocktransferController@tmasteOriginalDetail')->name('tmaster.originaldetails');

Route::get('{item}/markToserved', 'StocktransferController@markToserved');

Route::post('/saveRowPO', 'StocktransferController@saveRowPO');

Auth::routes();



Route::get('/home', 'HomeController@index');
Route::any('/home_ajax_action', 'HomeController@home_ajax_action');

Route::any('/username', 'LoginController@username');
Route::any('/password', 'LoginController@password');
Route::any('/one_time_pass', 'LoginController@one_time_pass');
Route::any('/resend_otp', 'LoginController@resend_otp');
Route::any('/logintype', 'LoginController@logintype');
Route::any('/ajax_action', 'LoginController@ajax_action');

Route::get('posts/{post}/edit', 'PostController@edit');
Route::get('test', 'LoginController@test');


#MasterFile Module
Route::resource('inventory', 'InventoryController', ['middleware' => 'auth']);
Route::resource('services', 'ServiceController', ['middleware' => 'auth']);
Route::resource('brands', 'BrandController', ['middleware' => 'auth']);
Route::resource('productlines', 'ProductLineController', ['middleware' => 'auth']);
Route::resource('satellite-branch', 'SatelliteBranchController', ['middleware' => 'auth']);
Route::resource('banks', 'BankController', ['middleware' => 'auth']);
Route::resource('bank-accounts', 'BankAccountController', ['middleware' => 'auth']);
Route::resource('checkbooks', 'CheckbookController', ['middleware' => 'auth']);
Route::resource('vendors', 'VendorController', ['middleware' => 'auth']);
Route::resource('vendor-management', 'VendorManagementController', ['middleware' => 'auth']);

// feature: service & retail item price configuration
Route::resource('retail-items-price-conf', 'RetailItemPriceConfController', ['middleware' => 'auth']);
Route::resource('services-price-conf', 'ServicePriceConfController', ['middleware' => 'auth']);
Route::get('/ajax/branches/{corp_id?}', ['as'=>'ajax.fetch.branches', 'uses'=>'AjaxController@fetchBrances']);
Route::get('/ajax/services/{service_id_csv?}', ['as'=>'ajax.fetch.services', 'uses'=>'AjaxController@fetchServices']);
Route::get('/ajax/retail-items/{product_id_csv?}', ['as'=>'ajax.fetch.retail-items', 'uses'=>'AjaxController@fetchRetailItems']);
// end of routes for feature: service & retail item price configuration

Route::post('/bank-accounts/update', 'BankAccountController@updateAccount', ['middleware' => 'auth']);
Route::post('/bank-accounts/delete', 'BankAccountController@destroy', ['middleware' => 'auth']);
Route::post('/banks/get-branches', 'BankController@getBranches')->middleware('auth');

Route::post('/vendor-management/get-account-for-vendor', 'VendorManagementController@getVendorAccount')->middleware('auth');
Route::post('/inventory/get-inventory-list', 'InventoryController@getInventoryList')->middleware('auth');
Route::post('/bank-accounts/change-default-account', 'BankAccountController@changeDefaultAccount')->middleware('auth');
Route::post('/satellite-branch/get-branch-list', 'SatelliteBranchController@getBranches')->middleware('auth');
Route::post('banks/get-banks-list', 'BankController@getBanksList')->middleware('auth');
Route::post('/checkbooks/get-accounts-for-branch', 'CheckbookController@getAccountForCheckbook')->middleware('auth');
Route::post('/checkbooks/get-checkbooks', 'CheckbookController@getCheekbooks')->middleware('auth');
Route::post('/checkbooks/edit-row-order', 'CheckbookController@editRowOrder')->middleware('auth');
Route::post('/checkbooks/delete', 'CheckbookController@destroy')->middleware('auth');
Route::post('/checkbooks/edit-checkbook', 'CheckbookController@update')->middleware('auth');
Route::post('/checkbooks/get-branches', 'CheckbookController@getBranches')->middleware('auth');
Route::post('/checkbooks/get-banks', 'CheckbookController@getBanks')->middleware('auth');
Route::post('/checkbooks/get-accounts-for-main', 'CheckbookController@getAccountsForMain')->middleware('auth');
Route::post('/vendors/get-branches', 'VendorController@getBranches')->middleware('auth');
#End of MasterFile Module

Route::resource('branchs', 'BranchsController', ['middleware' => 'auth']);
Route::put('branchs/{branch}/misc', 'BranchsController@updateMisc')->middleware('auth')->name('branchs.misc');
Route::resource('branchs.footers', 'FootersController', ['middleware' => 'auth']);
Route::put('branchs/{branch}/footers/{footer}/copy', 'FootersController@copy')->middleware('auth')->name('branchs.footers.copy');
Route::put('branchs/{branch}/macs/transfer', 'MacsController@transfer')->middleware('auth')->name('branchs.footers.transfer');
Route::put('branchs/{branch}/macs/swap', 'MacsController@swap')->middleware('auth')->name('branchs.footers.swap');
Route::resource('branchs.macs', 'MacsController', ['middleware' => 'auth']);
Route::resource('branchs.rooms', 'RoomsController', ['middleware' => 'auth']);
Route::get('/process_register/{?}', 'LoginController@process_register');
Route::get('/display_message/{?}', 'LoginController@display_message');

Route::put('branchs/{branch}/rates/assign', 'RatesController@assign')->middleware('auth')->name('branchs.rates.assign');
Route::resource('branchs.rates', 'RatesController', ['middleware' => 'auth']);
Route::put('branchs/{branch}/rates/{rate}/details', 'RatesController@details')->middleware('auth')->name('branchs.rates.details');

Route::resource('branchs.krates', 'KRatesController', ['middleware' => 'auth']);

Route::get('/user_list', 'HomeController@user_list');
Route::get('/finger_varification/{user_id}', 'LoginController@finger_varification');
Route::get('/get_logout', 'HomeController@get_logout');
Route::any('/forgot_pass', 'LoginController@forgot_pass');
Route::any('/change_pass/{user_id?}', 'LoginController@change_pass');

Route::any('/add_corporation/{corp_id?}', 'AccessLevelController@add_corporation');
Route::get('/list_corporation', 'AccessLevelController@list_corporation');
Route::get('/delete_corporation/{corp_id}', 'AccessLevelController@destroycorporation');

Route::any('/add_module/{module_id?}', 'AccessLevelController@add_module');
Route::get('/list_module', 'AccessLevelController@list_module');
Route::get('/delete_module/{module_id}', 'AccessLevelController@destroymodule');

Route::any('/add_feature/{feature_id?}/{module_id?}', 'AccessLevelController@add_feature');
Route::get('/list_feature/{module_id?}', 'AccessLevelController@list_feature');
Route::get('/delete_feature/{feature_id}/{module_id?}', 'AccessLevelController@destroyfeature');

Route::any('/add_template/{template_id?}', 'AccessLevelController@add_template');
Route::any('/template_module', 'AccessLevelController@template_module');
Route::get('/list_template', 'AccessLevelController@list_template');
Route::get('/delete_template/{template_id}', 'AccessLevelController@destroytemplate');
Route::get('/active_users', 'HomeController@login_logs');
Route::get('/logout', 'HomeController@logout');
Route::get('/template_exist', 'AccessLevelController@template_exist');
Route::any('/add_menu/{parent_id?}/{id?}', 'AccessLevelController@add_menu');
Route::any('/list_menu/{parent_id?}', 'AccessLevelController@list_menu');
Route::get('/delete_menu/{id}', 'AccessLevelController@delete_menu');
Route::any('/get_child_menu', 'AccessLevelController@get_child_menu');
Route::any('/add_group/{id?}', 'AccessLevelController@add_group');
Route::get('/list_group', 'AccessLevelController@list_group');
Route::get('/delete_group/{id}', 'AccessLevelController@delete_group');
Route::any('/update_active_group', 'AccessLevelController@update_active_group');
Route::get('/list_user', 'AccessLevelController@list_user');
Route::any('/add_user/{id?}', 'AccessLevelController@add_user');
Route::any('/city/{user_id?}', 'AccessLevelController@city');
Route::any('/branch/{user_id?}', 'AccessLevelController@branch');
Route::any('/provinces/{user_id?}', 'AccessLevelController@provinces');
Route::get('/delete_user/{id}', 'AccessLevelController@delete_user');

Route::any('/get_provinces_ids', 'AccessLevelController@get_provinces_ids');
Route::any('/get_city_ids', 'AccessLevelController@get_city_ids');
Route::any('/get_branch_ids', 'AccessLevelController@get_branch_ids');



Route::any('/get_child_menu_call', 'AccessLevelController@get_child_menu_call');

#Locations
Route::resource('list_provinces', 'LocationsController', ['middleware' => 'auth']);
Route::get('/view_cities/{prov_id?}','LocationsController@list_cities');// displaying cities within the province selected
Route::any('add_city/{city_id?}/{prov_id?}','LocationsController@add_city');
Route::any('/add_province/{prov_id?}','LocationsController@add_province');
Route::get('/delete_city/{city_id}/{prov_id}', 'LocationsController@deletecity');

#Purchase Order Module
Route::any('/purchase_order/{corp_id}/{city_id}/{id?}', 'PurchaseOrderController@purchase_order');
Route::any('/list_purchase_order', 'PurchaseOrderController@list_purchase_order');

Route::any('/product_branch', 'PurchaseOrderController@product_branch');
Route::any('/retail_items', 'PurchaseOrderController@retail_items');

Route::any('/501', 'PurchaseOrderController@module_not_found');

Route::resource('branch_remittances', 'BranchRemittanceController', ['middleware' => 'auth']);
Route::post('branch_remittances/collections', 'BranchRemittanceController@storeCollections')
       ->middleware('auth')->name('branch_remittances.collections.store');
Route::put('branch_remittances/{id}/remittances', 'BranchRemittanceController@updateRemittances')
       ->middleware('auth');
Route::post('branch_remittances/{id}/remittances', 'BranchRemittanceController@updateRemittanceStatus')
       ->middleware('auth');
Route::post('branch_remittances/render_modal', 'BranchRemittanceController@renderModal', ['middleware' => 'auth']);

Route::post('/stocks/{stock_id}/update_detail', 'StocksController@update_detail')->middleware('auth')->name('stocks.update_detail');
Route::post('/stocks/{stock_id}/save_new_row_ajax', 'StocksController@save_new_row_ajax')->middleware('auth')->name('stocks.save_new_row_ajax');
Route::post('/stocks/get_details', 'StocksController@get_details')->middleware('auth')->name('stocks.get_details');

Route::resource('stocks', 'StocksController', ['middleware' => 'auth']);
Route::any('/stocks/{stock_id}/{detail_id}' , 'StocksController@destroy_detail')->middleware('auth')->name('stocks.delete_detail');

Route::post('users/verify-password', 'UsersController@verifyPassword')->middleware('auth')->name('users.verifyPassword');
Route::post('users/generate-otp', 'UsersController@generateOTP')->middleware('auth')->name('users.generateOTP');
Route::post('users/verify-otp', 'UsersController@verifyOTP')->middleware('auth')->name('users.verifyOTP');