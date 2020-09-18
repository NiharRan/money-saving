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

  Route::get('/users', 'UserController@index')->name('users.index');
  Route::get('/profile/{slug}', 'UserProfileController@show')->name('users.profile');

  Route::get('/users/{slug}/transactions', 'UserTransactionController@create')->name('users.transactions.create');
  Route::get('/users/{userId}/transactions/{transactionId}', 'UserTransactionController@edit')->name('users.transactions.edit');

  Route::get('/accounts', 'AccountController@index')->name('accounts.index');
  Route::get('/accounts/profile/{slug}', 'AccountProfileController@show')->name('accounts.profile');

  Route::get('/customers', 'CustomerController@index')->name('customers.index');
  Route::get('/customers/profile/{slug}', 'CustomerProfileController@show')->name('customers.profile');

  Route::get('/accounts/{accountId}/transactions', 'AccountTransactionController@create')->name('accounts.transactions.create');
  Route::get('/accounts/{accountId}/transactions/{transactionId}', 'AccountTransactionController@edit')->name('accounts.transactions.edit');

  Route::get('/accounts/{accountId}/loans', 'AccountLoanController@create')->name('accounts.loans.create');
  Route::get('/accounts/{accountId}/loans/{loanId}', 'AccountLoanController@edit')->name('accounts.loans.edit');

  Route::delete('/transactions/{transactionId}', 'TransactionController@destroy')->name('transactions.destroy');
  Route::delete('/loans/{loanId}', 'LoanController@destroy')->name('loans.destroy');


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
    // routes called from vue.js
    Route::resource('genders', 'Settings\GenderController')->except(['create', 'edit', 'show']);
    Route::resource('religions', 'Settings\ReligionController')->except(['create', 'edit', 'show']);
    Route::resource('divisions', 'Settings\DivisionController')->except(['create', 'edit', 'show']);
    Route::resource('districts', 'Settings\DistrictController')->except(['create', 'edit', 'show']);
    Route::resource('upazillas', 'Settings\UpazillaController')->except(['create', 'edit', 'show']);

    Route::resource('roles', 'Settings\RoleController')->except(['create', 'edit']);

    Route::resource('account-types', 'Settings\AccountTypeController')->except(['create', 'edit', 'show']);
    Route::get('/account-types/search', 'Settings\AccountTypeController@search')->name('account-types.search');

    Route::resource('transaction-types', 'Settings\TransactionTypeController')->except(['create', 'edit', 'show']);
    Route::get('/transaction-types/search', 'Settings\TransactionTypeController@search')->name('transaction-types.search');

    Route::resource('money-formats', 'Settings\MoneyFormatController')->except(['create', 'edit', 'show']);
    Route::get('/money-formats/search', 'Settings\MoneyFormatController@search')->name('money-formats.search');

    Route::resource('users', 'UserController')->except(['create', 'edit', 'show']);
    Route::get('/users/search', 'UserController@search');
    Route::get('/users/profile/{slug}', 'UserProfileController@show');
    Route::get('/users/{userId}/accounts', 'UserAccountController@index')->name('users.accounts.index');
    Route::get('/users/{slug}/transactions', 'UserProfileController@index');

    Route::get('/users/{userId}/transactions', 'UserTransactionController@search')->name('users.transactions.index');
    Route::post('/users/transactions', 'UserTransactionController@store')->name('users.transactions.store');

    Route::resource('accounts', 'AccountController')->except(['create', 'edit','show', 'update']);
    Route::post('accounts/{accountId}', 'AccountController@update');
    Route::get('/accounts/search', 'AccountController@search');
    Route::get('/accounts/profile/{slug}', 'AccountProfileController@show');
    Route::get('/accounts/{slug}/transactions', 'AccountProfileController@index');

    Route::resource('customers', 'CustomerController')->except(['create', 'show', 'edit', 'update']);
    Route::post('customers/{customerId}', 'CustomerController@update')->name('customers.update');
    Route::get('/customers/search', 'CustomerController@search')->name('customers.search');

    Route::get('/accounts/{accountId}/transactions', 'AccountTransactionController@index')->name('accounts.transactions.index');
    Route::post('/accounts/transactions', 'AccountTransactionController@store')->name('accounts.transactions.store');
    Route::put('/accounts/{transactionId}/transactions', 'AccountTransactionController@update')->name('accounts.transactions.update');

    Route::get('/accounts/{accountId}/loans', 'AccountLoanController@index')->name('accounts.loans.index');
    Route::post('/accounts/loans', 'AccountLoanController@store')->name('accounts.loans.store');
    Route::put('/accounts/{loanId}/loans', 'AccountLoanController@update')->name('accounts.loans.update');


    Route::get('/transactions', 'TransactionController@index')->name('transactions.index');
    Route::get('/loans', 'LoanController@index')->name('loans.index');
  });
});
