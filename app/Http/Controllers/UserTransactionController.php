<?php

namespace App\Http\Controllers;

use App\Settings\TransactionType;
use App\User;
use Illuminate\Http\Request;

class UserTransactionController extends Controller
{
  /**
   * Show the form for creating a new resource.
   *
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
}
