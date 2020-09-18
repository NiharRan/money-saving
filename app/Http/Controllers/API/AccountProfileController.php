<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Repositories\AccountRepository;
use App\Repositories\TransactionRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;

class AccountProfileController extends Controller
{
  protected $transactionRepository;
  protected $accountRepository;
  public function __construct(TransactionRepository $transactionRepository, AccountRepository $accountRepository)
  {
    $this->transactionRepository = $transactionRepository;
    $this->accountRepository = $accountRepository;
  }

  /**
   * Display the specified resource.
   *
   * @param Request $request
   * @param $slug
   * @return string
   */
  public function index(Request $request, $slug)
  {
    $transactions = $this->transactionRepository->accountTransactionDataTable($request, $slug);
    return response()->json($transactions);
  }

  /**
   * Display the specified resource.
   *
   * @param $slug
   * @return string
   */
  public function show($slug)
  {
    $account = $this->accountRepository->findBySlug($slug);
    $transactionTypes = $this->accountRepository->transactionsByType($account);
    $users = $this->accountRepository->users($account->id);
    foreach ($users as $key => $user) {
      $users[$key]->transactionTypes = $this->accountRepository->transactionsByType($account, $user->id);
    }
    return response()->json([
      'account' => $account,
      'transactionTypes' => $transactionTypes,
      'users' => $users
    ]);
  }
}
