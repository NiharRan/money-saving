<?php

namespace App\Http\Controllers\API\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\AccountTypeRequest;
use App\Repositories\Settings\AccountTypeRepository;
use App\Settings\AccountType;
use Illuminate\Http\Response;

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
     * @return Response
     */
    public function index()
    {
        $account_types = $this->accountTypeRepository->all()->get();
        return response()->json($account_types);
    }
  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function search()
  {
    $account_types = $this->accountTypeRepository->all()->get();
    return response()->json($account_types);
  }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Response
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
     * @return Response
     */
    public function destroy(AccountType $accountType)
    {
        $name = $accountType->name;
        if ($accountType->delete()) return response()
            ->json(['success' => "$name deleted successfully!"]);
    }
}
