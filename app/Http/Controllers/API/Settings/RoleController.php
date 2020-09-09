<?php

namespace App\Http\Controllers\API\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\RoleRequest;
use App\Repositories\Settings\RoleRepository;
use App\Settings\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    private $roleRepository;
    function __construct(RoleRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      return $this->roleRepository->roleDataInTable();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\RoleRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleRequest $request)
    {
        $role = $this->roleRepository->store();
        if ($role) return response()
          ->json(['success' => "$role->name created successfully!"]);
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
     * @param  \Illuminate\Http\RoleRequest  $request
     * @param  \App\Users\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(RoleRequest $request, Role $role)
    {
      $role->name = $request->name;
      $role->status = $request->status;
      if ($role->save()) {
        return response()
          ->json(['success' => 'Role info updated successfully!']);
      }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Users\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
      $name = $role->name;
      if ($role->delete()) return response()
        ->json(['success' => "$name deleted successfully!"]);
    }
}
