<?php

namespace App\Http\Controllers;

class DashboardController extends Controller
{

  // Dashboard - Analytics
    public function index(){
        $pageConfigs = [
            'pageHeader' => false
        ];

        $config = [
          'text' => '',
          'vue' => true,
        ];

        return view('/pages/dashboard', [
          'pageConfigs' => $pageConfigs,
          'config' => $config,
        ]);
    }

}

