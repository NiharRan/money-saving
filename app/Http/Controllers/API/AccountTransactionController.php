<?php

namespace App\Http\Controllers\API;

use App\Account;
use App\Http\Controllers\Controller;
use App\Http\Requests\TransactionRequest;
use App\Repositories\TransactionRepository;
use Illuminate\Http\Request;

class AccountTransactionController extends Controller
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
        return $this->transactionRepository->accountTransactionsDataInTable($id);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\TransactionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TransactionRequest $request)
    {
        $transaction = $this->transactionRepository->store();
        if ($transaction) {
            $account = Account::find($request->account_id);
            return response()->json([
                'success' => __('Transaction stored Message'),
                'redirect_to' => route('accounts.profile', $account->slug)
            ]);
        }
    }

  /**
   * Update the specified resource in storage.
   *
   * @param TransactionRequest $request
   * @param int $id
   * @return void
   */
    public function update(TransactionRequest $request, $id)
    {
        $transaction = $this->transactionRepository->update($id);
        if ($transaction) {
          $account = Account::find($request->account_id);
          return response()->json([
            'success' => __('Transaction updated Message'),
            'redirect_to' => route('accounts.profile', $account->slug)
          ]);
        }
    }

}
