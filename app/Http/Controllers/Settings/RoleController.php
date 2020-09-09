<?php

namespace App\Http\Controllers\Settings;

use App\Repositories\Settings\RoleRepository;
use App\Settings\Role;
use App\Http\Controllers\Controller;

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
      $breadcrumbs = [
        ['link'=>"/",'name'=>"Home"],['link'=>"",'name'=>"Roles"]
      ];
      return view('/pages/roles/index', [
        'breadcrumbs' => $breadcrumbs
      ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $breadcrumbs = [
        ['link'=>"/",'name'=>"Home"],
        ['link'=>"/roles",'name'=>"Roles"],
        ['link'=>"",'name'=>"Create New Role"],
      ];
      return view('/pages/roles/create', [
        'breadcrumbs' => $breadcrumbs
      ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Settings\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
      $breadcrumbs = [
        ['link'=>"/",'name'=>"Home"],
        ['link'=>"/roles",'name'=>"Roles"], ['name'=>"Edit Role"]
      ];
      return view('/pages/roles/edit', [
        'breadcrumbs' => $breadcrumbs
      ])->withRole($role);
    }
}
