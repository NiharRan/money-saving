<?php

namespace App\Http\Controllers;

use App\Settings\TransactionType;
use App\Transaction;
use App\User;

class UserTransactionController extends Controller
{
  /**
   * Show the form for creating a new resource.
   *
   * @param $id
   * @return \Illuminate\Http\Response
   */
  public function create($id)
  {
    $transactionTypes = TransactionType::active()->orderBy('name', 'asc')->get();
    $user = User::with('accounts')->find($id);
    $pageConfigs = [
      'pageHeader' => true
    ];
    $breadcrumbs = [
      ['link'=>"/",'name'=>"Home"],
      ['link'=>route('users.profile', $user->slug),'name'=> $user->name],
      ['name'=> "Create New Transaction"],
    ];
    return view('/pages/users/transaction', [
      'breadcrumbs' => $breadcrumbs
    ])->with([
      'transactionTypes' => $transactionTypes,
      'accounts' => $user->accounts,
      'user_id' => $id
    ]);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param $userId
   * @param $transactionId
   * @return void
   */
  public function edit($userId, $transactionId)
  {
    $user = User::find($userId);
    $transaction = Transaction::find($transactionId);
    $transactionTypes = TransactionType::active()->orderBy('name', 'asc')->get();
    $pageConfigs = [
      'pageHeader' => true
    ];
    $breadcrumbs = [
      ['link'=>"/",'name'=> __("Home")],
      ['link'=> route('users.profile', $user->slug),'name'=> $user->name],
      ['name'=> __("Transaction Edit Message", [
        't' => $transaction->invoice,
        'a' => $user->name
      ])],
    ];
    return view('/pages/accounts/transaction-edit', [
      'breadcrumbs' => $breadcrumbs
    ])->with([
      'transactionTypes' => $transactionTypes,
      'transaction' => $transaction,
      'user_id' => $userId,
    ]);
  }
}
