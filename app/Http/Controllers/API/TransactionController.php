<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Repositories\TransactionRepository;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
  protected $transactionRepository;
  public function __construct(TransactionRepository $transactionRepository)
  {
    $this->transactionRepository = $transactionRepository;
  }

  /**
   * Display the specified resource.
   *
   * @param Request $request
   * @return string
   */
  public function index(Request $request)
  {
    $transactions = $this->transactionRepository->dataTable($request);
    return response()->json($transactions);
  }
}
