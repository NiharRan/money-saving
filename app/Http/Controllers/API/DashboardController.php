<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
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
}
