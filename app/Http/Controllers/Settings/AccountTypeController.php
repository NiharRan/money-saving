<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Settings\AccountType;
use Illuminate\Http\Request;

class AccountTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $pageConfigs = [
        'pageHeader' => true
      ];
      $breadcrumbs = [
        ['link'=>"/",'name'=>"Home"],
        ['name'=>"Account Type"],
      ];
      return view('/pages/account-types/index', [
        'breadcrumbs' => $breadcrumbs
      ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $breadcrumbs = [
        ['link'=>"/",'name'=>"Home"],
        ['link'=>"/account-types",'name'=>"Account Types"],
        ['link'=>"",'name'=>"Create New Account Type"],
      ];
      return view('/pages/account-types/create', [
        'breadcrumbs' => $breadcrumbs
      ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Settings\AccountType  $accountType
     * @return \Illuminate\Http\Response
     */
    public function edit(AccountType $accountType)
    {
      $breadcrumbs = [
        ['link'=>"/",'name'=>"Home"],
        ['link'=>"/account-types",'name'=>"Account Types"], ['name'=>"Edit Account Type"]
      ];
      return view('/pages/account-types/edit', [
        'breadcrumbs' => $breadcrumbs
      ])->withAccountType($accountType);
    }
}
