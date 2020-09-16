<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepository;
use App\Settings\Division;
use App\Users\BloodGroup;
use App\Users\Gender;
use App\Users\Religion;
use App\Settings\Role;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

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
     * @return Response
     */
    public function index()
    {
      $pageConfigs = [
        'pageHeader' => true
      ];
      $breadcrumbs = [
        ['link'=>"/",'name'=> __('Home')],
        ['name'=> __("Users") ],
      ];
      return view('/pages/users/index', [
        'breadcrumbs' => $breadcrumbs
      ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
      $genders = Gender::active()->get();
      $bloodGroups = BloodGroup::active()->get();
      $roles = Role::active()->get();
      $religions = Religion::active()->get();
      $divisions = Division::active()->get();
      $pageConfigs = [
        'pageHeader' => true
      ];
      $breadcrumbs = [
        ['link'=>"/",'name'=> __("Home")],
        ['link' => '/users', 'name'=> __("Users")],
        ['name'=> __("Create New User")],
      ];
      return view('/pages/users/create', [
        'breadcrumbs' => $breadcrumbs
      ])->with([
        'genders' => $genders,
        'bloodGroups' => $bloodGroups,
        'roles' => $roles,
        'religions' => $religions,
        'divisions' => $divisions,
      ]);
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
      $user = $this->userRepository->findById($id);
      $genders = Gender::active()->get();
      $bloodGroups = BloodGroup::active()->get();
      $religions = Religion::active()->get();
      $divisions = Division::active()->get();
      $pageConfigs = [
        'pageHeader' => true
      ];
      $breadcrumbs = [
        ['link'=>"/",'name'=>__('Home')],
        ['link' => '/users','name'=> __('Users')],
        ['name' => __('Update Information')]
      ];
      return view('/pages/users/edit', [
        'pageConfigs' => $pageConfigs,
        'breadcrumbs' => $breadcrumbs
      ])->with([
        'user' => $user,
        'genders' => $genders,
        'bloodGroups' => $bloodGroups,
        'religions' => $religions,
        'divisions' => $divisions,
      ]);
    }
}
