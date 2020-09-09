<?php

namespace App\Http\Controllers\Settings;

use App\Repositories\Settings\TransactionTypeRepository;
use App\Settings\TransactionType;
use App\Http\Controllers\Controller;

class TransactionTypeController extends Controller
{
  private $transactionTypeRepository;
  function __construct(TransactionTypeRepository $transactionTypeRepository)
  {
    $this->transactionTypeRepository = $transactionTypeRepository;
  }

  /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $breadcrumbs = [
        ['link'=>"/",'name'=>"Home"],['link'=>"",'name'=>"Transaction Types"]
      ];
      return view('/pages/transaction-types/index', [
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
        ['link'=>"/transaction-types",'name'=>"Transaction Types"],
        ['link'=>"",'name'=>"Create New Transaction Type"],
      ];
      return view('/pages/transaction-types/create', [
        'breadcrumbs' => $breadcrumbs
      ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Settings\TransactionType  $transactionType
     * @return \Illuminate\Http\Response
     */
    public function edit(TransactionType $transactionType)
    {
      $breadcrumbs = [
        ['link'=>"/",'name'=>"Home"],
        ['link'=>"/transaction-types",'name'=>"Transaction Types"], ['name'=>"Edit Transaction Type"]
      ];
      return view('/pages/transaction-types/edit', [
        'breadcrumbs' => $breadcrumbs
      ])->withTransactionType($transactionType);
    }
}
