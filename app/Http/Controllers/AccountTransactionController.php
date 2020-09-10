<?php

namespace App\Http\Controllers;

use App\Account;
use App\Settings\TransactionType;
use Illuminate\Http\Request;

class AccountTransactionController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
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
          ['link'=>"/",'name'=>"Home"],
          ['link'=> route('accounts.profile', $account->slug),'name'=> $account->name],
            ['name'=> "Create New Transaction"],
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }
}
