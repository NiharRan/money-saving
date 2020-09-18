<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Repositories\TransactionRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;

class UserProfileController extends Controller
{
  protected $transactionRepository;
  protected $userRepository;
  public function __construct(TransactionRepository $transactionRepository, UserRepository $userRepository)
  {
    $this->transactionRepository = $transactionRepository;
    $this->userRepository = $userRepository;
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
    $transactions = $this->transactionRepository->userTransactionDataTable($request, $slug);
    return response()->json($transactions);
  }

  /**
   * Display the specified resource.
   *
   * @param Request $request
   * @return string
   */
  public function show($slug)
  {
    $user = $this->userRepository->findBySlug($slug);
    $transactionTypes = $this->userRepository->transactionAmountByType($user);
    $accounts = $this->userRepository->accounts($user->id);
    foreach ($accounts as $key => $account) {
      $accounts[$key]->transactionTypes = $this->userRepository->transactionAmountByType($user, $account);
    }
    return response()->json([
      'user' => $user,
      'transactionTypes' => $transactionTypes,
      'accounts' => $accounts
    ]);
  }
}
