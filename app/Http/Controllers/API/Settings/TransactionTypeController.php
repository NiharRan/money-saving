<?php

namespace App\Http\Controllers\API\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\TransactionTypeRequest;
use App\Repositories\Settings\TransactionTypeRepository;
use App\Settings\AccountType;
use App\Settings\TransactionType;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

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
     * @return Response
     */
    public function index()
    {
        return $this->transactionTypeRepository->transactionTypeDataInTable();
    }

  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function search()
  {
    $rows = $this->transactionTypeRepository->all()->get();
    return response()->json($rows);
  }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Response
     */
    public function store(TransactionTypeRequest $request)
    {
        $transactionType = $this->transactionTypeRepository->store();
        if ($transactionType) return response()
          ->json(['success' => "$transactionType->name created successfully!"]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(TransactionTypeRequest $request, $id)
    {
        $transactionType = $this->transactionTypeRepository->update($id);
        if ($transactionType) {
            return response()
            ->json(['success' => 'Transaction type info updated successfully!']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy(TransactionType $transactionType)
    {
        $name = $transactionType->name;
        if ($transactionType->delete()) return response()
            ->json(['success' => "$name deleted successfully!"]);
    }
}
