<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\AccountUpdateRequest;
use App\Http\Requests\AccountCreateRequest;
use App\Repositories\AccountRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class AccountController extends Controller
{
    protected $accountRepository;
    public function __construct(AccountRepository $accountRepository)
    {
      $this->accountRepository = $accountRepository;
    }

  /**
   * Display a listing of the resource.
   *
   * @param Request $request
   * @return JsonResponse
   */
    public function index(Request $request)
    {
        $accounts = $this->accountRepository->dataTable($request);
        return \response()->json($accounts);
    }
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function search()
    {
      $data = $this->accountRepository->all()->get();
      return \response()->json($data);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param AccountCreateRequest $request
     * @return Response
     */
    public function store(AccountCreateRequest $request)
    {
        $account = $this->accountRepository->store();
        if ($request->hasFile('logo')) {
            $extension = $request->file('logo')->extension();
            //filename to store
            $fileNameToStore = \time().'.'.$extension;

            //Upload File
            $this->accountRepository->uploadImage($fileNameToStore, $request);

            $account->logo = $fileNameToStore;
        }
        if ($account->save()) {
            return response()
              ->json(['success' => 'Account created successfully!']);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param AccountUpdateRequest $request
     * @param  int  $id
     * @return Response
     */
    public function update(AccountUpdateRequest $request, $id)
    {
        $account = $this->accountRepository->update($id);
        if ($request->hasFile('logo')) {
            if ($account->logo != 'account.png') {
              $originalImagePath = 'public/accounts/'.$account->logo;
              $mediumImagePath = 'public/accounts/thumbnail/medium/'.$account->logo;
              $smallImagePath = 'public/accounts/thumbnail/small/'.$account->logo;
              if (file_exists($originalImagePath)) {
                    Storage::delete($originalImagePath);
                }
                if (file_exists($smallImagePath)) {
                    Storage::delete($smallImagePath);
                }
                if (file_exists($mediumImagePath)) {
                    Storage::delete($mediumImagePath);
                }
            }

            $extension = $request->file('logo')->extension();
            //filename to store
            $fileNameToStore = \time().'.'.$extension;

            //Upload File
            $this->accountRepository->uploadImage($fileNameToStore, $request);

            $account->logo = $fileNameToStore;
        }
        if ($account->save()) {
            return response()
              ->json(['success' => 'Account Updated successfully!']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
