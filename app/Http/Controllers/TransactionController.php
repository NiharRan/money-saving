<?php

namespace App\Http\Controllers;

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
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $transaction = $this->transactionRepository->findById($id);
    if ($this->transactionRepository->destroy($id)) {
      return redirect()->back()
        ->with('success', "$transaction->invoice is deleted successfully");
    }
  }
}
