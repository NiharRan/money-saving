<?php

namespace App\Http\Controllers\API;

use App\Account;
use App\Http\Controllers\Controller;
use App\Http\Requests\TransactionCreateRequest;
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
     * @param  \App\Http\Requests\TransactionCreateRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TransactionCreateRequest $request)
    {
        $transaction = $this->transactionRepository->store();
        if ($transaction) {
            $account = Account::find($request->account_id); 
            return response()->json([
                'success' => 'Transaction Created Successfully',
                'redirect_to' => route('accounts.profile', $account->slug)
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
