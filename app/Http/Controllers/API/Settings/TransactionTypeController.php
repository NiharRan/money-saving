<?php

namespace App\Http\Controllers\API\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\TransactionTypeRequest;
use App\Repositories\Settings\TransactionTypeRepository;
use App\Settings\AccountType;
use App\Settings\TransactionType;
use Illuminate\Http\Request;

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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->transactionTypeRepository->transactionTypeDataInTable();
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
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
     * @return \Illuminate\Http\Response
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
     * @return \Illuminate\Http\Response
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
     * @return \Illuminate\Http\Response
     */
    public function destroy(TransactionType $transactionType)
    {
        $name = $transactionType->name;
        if ($transactionType->delete()) return response()
            ->json(['success' => "$name deleted successfully!"]);
    }
}
