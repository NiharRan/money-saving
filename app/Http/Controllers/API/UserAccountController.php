<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;

class UserAccountController extends Controller
{
  protected $userRepository;
  public function __construct(UserRepository $userRepository)
  {
    $this->userRepository = $userRepository;
  }

  /**
   * Display a listing of the resource.
   *
   * @param $userId
   * @return Response
   */
  public function index($userId)
  {
    $accounts = $this->userRepository->accounts($userId);
    return response()->json($accounts);
  }
}
