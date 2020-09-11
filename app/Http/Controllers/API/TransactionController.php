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
   * @return string
   */
  public function index()
  {
    return $this->transactionRepository->transactionsDataInTable();
  }
}
