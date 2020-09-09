<?php

namespace App\Http\Controllers\API\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\AccountTypeRequest;
use App\Repositories\Settings\AccountTypeRepository;
use App\Settings\AccountType;

class AccountTypeController extends Controller
{
    private $accountTypeRepository;
    function __construct(AccountTypeRepository $accountTypeRepository)
    {
        $this->accountTypeRepository = $accountTypeRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->accountTypeRepository->accountTypeDataInTable();
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AccountTypeRequest $request)
    {
        $accountType = $this->accountTypeRepository->store();
        if ($accountType) return response()
          ->json(['success' => "$accountType->name created successfully!"]);
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
    public function update(AccountTypeRequest $request, AccountType $accountType)
    {
        $accountType = $this->accountTypeRepository->update($accountType->id);
        if ($accountType) {
            return response()
            ->json(['success' => 'Account type info updated successfully!']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(AccountType $accountType)
    {
        $name = $accountType->name;
        if ($accountType->delete()) return response()
            ->json(['success' => "$name deleted successfully!"]);
    }
}
