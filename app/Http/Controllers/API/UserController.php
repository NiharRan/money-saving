<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\UserCreateRequest;
use App\Http\Requests\Users\UserUpdateRequest;
use App\Repositories\UserRepository;
use App\Settings\Role;
use Illuminate\Http\Request;
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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->userRepository->userDataInTable();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
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
            $request->file('avatar')->storeAs('public/users', $fileNameToStore);
            $request->file('avatar')->storeAs('public/users/thumbnail/small', $fileNameToStore);
            $request->file('avatar')->storeAs('public/users/thumbnail/medium', $fileNameToStore);

            //create small thumbnail
            $smallThumbnailPath = public_path('storage/users/thumbnail/small/'.$fileNameToStore);
            $this->userRepository->createThumbnail($smallThumbnailPath, 150, 93);

            //create medium thumbnail
            $mediumThumbnailPath = public_path('storage/users/thumbnail/medium/'.$fileNameToStore);
            $this->userRepository->createThumbnail($mediumThumbnailPath, 300, 185);

            $user->avatar = $fileNameToStore;
        }
        if ($user->save()) {
            return response()->json(['success' => 'User registration completed successfully!']);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request, $id)
    {
        $user = $this->userRepository->update($request, $id);
        // new image provided
        if ($request->hasFile('avatar')) {
            $originalImagePath = 'public/users/'.$user->avatar;
            $smallImagePath = 'public/users/thumbnail/small/'.$user->avatar;
            $mediumImagePath = 'public/users/thumbnail/medium/'.$user->avatar;
            Storage::delete($originalImagePath);
            Storage::delete($smallImagePath);
            Storage::delete($mediumImagePath);

            $extension = $request->file('avatar')->extension();
            //filename to store
            $fileNameToStore = \time().'.'.$extension;

            //Upload File
            $request->file('avatar')->storeAs('public/users', $fileNameToStore);
            $request->file('avatar')->storeAs('public/users/thumbnail/small', $fileNameToStore);
            $request->file('avatar')->storeAs('public/users/thumbnail/medium', $fileNameToStore);

            //create small thumbnail
            $smallThumbnailPath = public_path('storage/users/thumbnail/small/'.$fileNameToStore);
            $this->userRepository->createThumbnail($smallThumbnailPath, 150, 93);

            //create medium thumbnail
            $mediumThumbnailPath = public_path('storage/users/thumbnail/medium/'.$fileNameToStore);
            $this->userRepository->createThumbnail($mediumThumbnailPath, 300, 185);

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
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
