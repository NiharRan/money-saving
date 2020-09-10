<?php

namespace App\Http\Controllers;

use App\Repositories\AccountRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected $userRepository;
    protected $accountRepository;
    public function __construct( UserRepository $userRepository, AccountRepository $accountRepository)
    {
      $this->userRepository = $userRepository;
      $this->accountRepository = $accountRepository;
    }

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

