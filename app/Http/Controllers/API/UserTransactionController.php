<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\TransactionCreateRequest;
use App\Repositories\TransactionRepository;
use App\User;

class UserTransactionController extends Controller
{
  protected $transactionRepository;
  public function __construct(TransactionRepository $transactionRepository)
  {
    $this->transactionRepository = $transactionRepository;
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function index($id)
  {
    return $this->transactionRepository->userTransactionsDataInTable($id);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \App\Http\Requests\TransactionCreateRequest  $request
   * @return \Illuminate\Http\Response
   */
  public function store(TransactionCreateRequest $request)
  {
    $transaction = $this->transactionRepository->store();
    if ($transaction) {
      $user = User::find($request->user_id);
      return response()->json([
        'success' => 'Transaction Created Successfully',
        'redirect_to' => route('users.profile', $user->slug)
      ]);
    }
  }
}
