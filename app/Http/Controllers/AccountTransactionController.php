<?php

namespace App\Http\Controllers;

use App\Account;
use App\Settings\TransactionType;
use App\Transaction;
use Illuminate\Http\Request;

class AccountTransactionController extends Controller
{
  /**
   * Show the form for creating a new resource.
   *
   * @param $id
   * @return \Illuminate\Http\Response
   */
    public function create($id)
    {
        $account = Account::find($id);
        $transactionTypes = TransactionType::active()->orderBy('name', 'asc')->get();
        $pageConfigs = [
            'pageHeader' => true
        ];
        $breadcrumbs = [
          ['link'=>"/",'name'=> __('Home')],
          ['link'=> route('accounts.profile', $account->slug),'name'=> $account->name],
            ['name'=> __('Transaction Create Message')],
        ];
        return view('/pages/accounts/transaction', [
            'breadcrumbs' => $breadcrumbs
        ])->with([
            'transactionTypes' => $transactionTypes,
            'account_id' => $id
        ]);
    }


  /**
   * Show the form for editing the specified resource.
   *
   * @param $accountId
   * @param $transactionId
   * @return void
   */
    public function edit($accountId, $transactionId)
    {
      $account = Account::find($accountId);
      $transaction = Transaction::find($transactionId);
      $transactionTypes = TransactionType::active()->orderBy('name', 'asc')->get();
      $pageConfigs = [
        'pageHeader' => true
      ];
      $breadcrumbs = [
        ['link'=>"/",'name'=> __("Home")],
        ['link'=> route('accounts.profile', $account->slug),'name'=> $account->name],
        ['name'=> __("Transaction Edit Message", [
          't' => $transaction->invoice,
          'a' => $account->name
        ])],
      ];
      return view('/pages/accounts/transaction-edit', [
        'breadcrumbs' => $breadcrumbs
      ])->with([
        'transactionTypes' => $transactionTypes,
        'transaction' => $transaction,
        'account_id' => $accountId,
      ]);
    }
}
