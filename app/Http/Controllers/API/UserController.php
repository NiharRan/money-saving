<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\UserCreateRequest;
use App\Http\Requests\Users\UserUpdateRequest;
use App\Repositories\UserRepository;
use App\Settings\Role;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    protected $userRepository;
    public function __construct(UserRepository $userRepository)
    {
      $this->userRepository = $userRepository;
    }

  /**
   * Display a listing of the resource.
   *
   * @param Request $request
   * @return JsonResponse
   */
    public function index(Request $request)
    {
      $users = $this->userRepository->dataTable($request);
      return \response()->json($users);
    }

    /**
     * @return JsonResponse
     */
    public function search()
    {
        $users = $this->userRepository->all()->get();
        return response()->json($users);
    }

  /**
   * Store a newly created resource in storage.
   *
   * @param UserCreateRequest $request
   * @return Response
   */
    public function store(UserCreateRequest $request)
    {
        $role = Role::where('name', 'Subscriber')->first();
        $user = $this->userRepository->store($request);
        $user->role_id = $role->id;
        if ($request->hasFile('avatar')) {
            $extension = $request->file('avatar')->extension();
            //filename to store
            $fileNameToStore = \time().'.'.$extension;

            //Upload File
            $this->userRepository->uploadImage($fileNameToStore, $request);

            $user->avatar = $fileNameToStore;
        }
        if ($user->save()) {
            return response()->json(['success' => 'User registration completed successfully!']);
        }
    }

  /**
   * Update the specified resource in storage.
   *
   * @param UserUpdateRequest $request
   * @param int $id
   * @return Response
   */
    public function update(UserUpdateRequest $request, $id)
    {
        $user = $this->userRepository->update($request, $id);
        // new image provided
        if ($request->hasFile('avatar')) {
            if ($user->avatar !== 'default.jpg') {
              $originalImagePath = 'public/users/'.$user->avatar;
              $smallImagePath = 'public/users/thumbnail/small/'.$user->avatar;
              $mediumImagePath = 'public/users/thumbnail/medium/'.$user->avatar;
              if(file_exists($originalImagePath)) {
                Storage::delete($originalImagePath);
              }
              if(file_exists($smallImagePath)) {
                Storage::delete($smallImagePath);
              }
              if(file_exists($mediumImagePath)) {
                Storage::delete($mediumImagePath);
              }
            }

            $extension = $request->file('avatar')->extension();
            //filename to store
            $fileNameToStore = \time().'.'.$extension;

            //Upload File
            $this->userRepository->uploadImage($fileNameToStore, $request);

            $user->avatar = $fileNameToStore;
        }
        if ($user->save()) {
            return response()->json(['success' => "$user->name's information updated successfully!"]);
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
