<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerCreateRequest;
use App\Http\Requests\CustomerUpdateRequest;
use App\Repositories\CustomerRepository;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CustomerController extends Controller
{
  protected $customerRepository;
  public function __construct(CustomerRepository $customerRepository)
  {
    $this->customerRepository = $customerRepository;
  }

  /**
   * Display a listing of the resource.
   *
   * @param Request $request
   * @return JsonResponse
   */
  public function index(Request $request)
  {
    $data = $this->customerRepository->dataTable($request);
    return \response()->json($data);
  }

  /**
   * Display a listing of the resource.
   *
   * @return JsonResponse
   */
  public function search()
  {
    $data = $this->customerRepository->all()->get();
    return \response()->json($data);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param CustomerCreateRequest $request
   * @return Response
   */
  public function store(CustomerCreateRequest $request)
  {
    $customer = $this->customerRepository->store($request);
    if ($request->hasFile('avatar')) {
      $extension = $request->file('avatar')->extension();
      //filename to store
      $fileNameToStore = \time().'.'.$extension;

      //Upload File
      $this->customerRepository->uploadImage($fileNameToStore, $request);

      $customer->avatar = $fileNameToStore;
    }
    if ($customer->save()) {
      return response()->json(['success' => __('Information saved successfully!')]);
    }
  }

  /**
   * Update the specified resource in storage.
   *
   * @param CustomerUpdateRequest $request
   * @param int $id
   * @return Response
   */
  public function update(CustomerUpdateRequest $request, $id)
  {
    $customer = $this->customerRepository->update($request, $id);
    // new image provided
    if ($request->hasFile('avatar')) {
      if($request->avatar !== 'default.jpg') {
        $originalImagePath = 'public/customers/'.$customer->avatar;
        Storage::delete($originalImagePath);
      }
      if($request->avatar !== 'default.jpg') {
        $smallImagePath = 'public/customers/thumbnail/small/'.$customer->avatar;
        Storage::delete($smallImagePath);
      }
      if($request->avatar !== 'default.jpg') {
        $mediumImagePath = 'public/customers/thumbnail/medium/'.$customer->avatar;
        Storage::delete($mediumImagePath);
      }

      $extension = $request->file('avatar')->extension();
      //filename to store
      $fileNameToStore = \time().'.'.$extension;

      //Upload File
      $this->customerRepository->update($fileNameToStore, $request);

      $customer->avatar = $fileNameToStore;
    }
    if ($customer->save()) {
      return response()->json(['success' => __("Information updated successfully!")]);
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
