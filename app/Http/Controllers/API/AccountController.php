<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\AccountUpdateRequest;
use App\Http\Requests\AccountCreateRequest;
use App\Repositories\AccountRepository;
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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->accountRepository->accountDataInTable();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\AccountCreateRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AccountCreateRequest $request)
    {
        $account = $this->accountRepository->store();
        if ($request->hasFile('logo')) {
            $extension = $request->file('logo')->extension();
            //filename to store
            $fileNameToStore = \time().'.'.$extension;

            //Upload File
            $request->file('logo')->storeAs('public/accounts', $fileNameToStore);
            $request->file('logo')->storeAs('public/accounts/thumbnail/small', $fileNameToStore);
            $request->file('logo')->storeAs('public/accounts/thumbnail/medium', $fileNameToStore);

            //create small thumbnail
            $smallThumbnailPath = public_path('storage/accounts/thumbnail/small/'.$fileNameToStore);
            $this->accountRepository->createThumbnail($smallThumbnailPath, 150, 93);

            //create medium thumbnail
            $mediumThumbnailPath = public_path('storage/accounts/thumbnail/medium/'.$fileNameToStore);
            $this->accountRepository->createThumbnail($mediumThumbnailPath, 300, 185);

            $account->logo = $fileNameToStore;
        }
        if ($account->save()) {
            return response()->json(['success' => 'Account created successfully!']);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\AccountUpdateRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AccountUpdateRequest $request, $id)
    {
        $account = $this->accountRepository->update($id);
        if ($request->hasFile('logo')) {
            $originalImagePath = 'public/accounts/'.$account->logo;
            $smallImagePath = 'public/accounts/thumbnail/small/'.$account->logo;
            $mediumImagePath = 'public/accounts/thumbnail/medium/'.$account->logo;
            if ($account->logo != 'account.png') {
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
            $request->file('logo')->storeAs('public/accounts', $fileNameToStore);
            $request->file('logo')->storeAs('public/accounts/thumbnail/small', $fileNameToStore);
            $request->file('logo')->storeAs('public/accounts/thumbnail/medium', $fileNameToStore);

            //create small thumbnail
            $smallThumbnailPath = public_path('storage/accounts/thumbnail/small/'.$fileNameToStore);
            $this->accountRepository->createThumbnail($smallThumbnailPath, 150, 93);

            //create medium thumbnail
            $mediumThumbnailPath = public_path('storage/accounts/thumbnail/medium/'.$fileNameToStore);
            $this->accountRepository->createThumbnail($mediumThumbnailPath, 300, 185);

            $account->logo = $fileNameToStore;
        }
        if ($account->save()) {
            return response()->json(['success' => 'Account Updated successfully!']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
