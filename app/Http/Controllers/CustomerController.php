<?php

namespace App\Http\Controllers;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $config = [
        'text' => __('New'),
        'vue' => true,
      ];
      $breadcrumbs = [
        ['link'=>"/",'name'=> __("Home")],
        ['link' => '/users', 'name'=> __("Customers")],
      ];
      return view('/pages/customers/index', [
        'breadcrumbs' => $breadcrumbs,
        'config' => $config
      ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $config = [
        'text' => '',
        'vue' => true,
      ];
      $breadcrumbs = [
        ['link'=>"/",'name'=> __("Home")],
        ['link' => '/users', 'name'=> __("Customers")],
        ['name'=> __("Create New Customer")],
      ];
      return view('/pages/customers/create', [
        'breadcrumbs' => $breadcrumbs,
        'config' => $config
      ]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }
}
