<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    // Dashboard - Analytics
    public function index(){
        $pageConfigs = [
            'pageHeader' => false
        ];

        return view('/pages/dashboard', [
            'pageConfigs' => $pageConfigs
        ]);
    }

}

