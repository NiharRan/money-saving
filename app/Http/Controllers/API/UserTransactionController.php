<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\TransactionRequest;
use App\Repositories\TransactionRepository;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use JamesDordoy\LaravelVueDatatable\Http\Resources\DataTableCollectionResource;

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
   * @param Request $request
   * @param int $id
   * @return DataTableCollectionResource
   */
  public function index(Request $request, int $id)
  {
    return $this->transactionRepository->dataTable($request);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \App\Http\Requests\TransactionRequest  $request
   * @return Response
   */
  public function store(TransactionRequest $request)
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
