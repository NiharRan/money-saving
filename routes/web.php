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


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::middleware(['auth', 'lang'])->group(function () {
  // Route url
  Route::get('/', 'DashboardController@index');

// Route Dashboards
  Route::get('/dashboard', 'DashboardController@index');

  Route::resource('users', 'UserController')->only(['index', 'create', 'edit']);
  Route::resource('accounts', 'AccountController')->only(['index', 'create', 'edit']);
  Route::get('/{slug}', 'UserProfileController@show')->name('users.profile');
  Route::get('/{slug}/transactions', 'UserTransactionController@create')->name('users.transactions.create');

  Route::get('/accounts/{slug}', 'AccountProfileController@show')->name('accounts.profile');
  Route::get('/accounts/{accountId}/transactions', 'AccountTransactionController@create')->name('accounts.transactions.create');


  Route::group([
    'prefix' => 'settings',
    'namespace' => 'Settings',
  ], function() {
      Route::resource('account-types', 'AccountTypeController');
      Route::resource('transaction-types', 'TransactionTypeController');
      Route::resource('money-formats', 'MoneyFormatController');
      Route::resource('roles', 'RoleController');
  });



  Route::group([
    'prefix' => 'api',
    'namespace' => 'API',
    'as' => 'api.'
  ],function ()
  {
    Route::resource('roles', 'Settings\RoleController')->except(['create', 'edit']);
    Route::resource('account-types', 'Settings\AccountTypeController')->except(['create', 'edit']);
    Route::resource('transaction-types', 'Settings\TransactionTypeController')->except(['create', 'edit']);
    Route::resource('money-formats', 'Settings\MoneyFormatController')->except(['create', 'edit']);

    Route::resource('users', 'UserController')->except(['create', 'edit']);
    Route::get('users/{userId}/transactions', 'UserTransactionController@index')->name('users.transactions.index');
    Route::post('users/transactions', 'UserTransactionController@store')->name('users.transactions.store');

    Route::resource('accounts', 'AccountController')->except(['create', 'edit']);
    Route::get('accounts/{accountId}/transactions', 'AccountTransactionController@index')->name('accounts.transactions.index');
    Route::post('accounts/transactions', 'AccountTransactionController@store')->name('accounts.transactions.store');


    Route::get('/transactions', 'TransactionController@index')->name('transactions.index');
  });
});
