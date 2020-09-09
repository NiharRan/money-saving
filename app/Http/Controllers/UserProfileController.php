<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepository;
use Illuminate\Http\Request;

class UserProfileController extends Controller
{
    protected $userRepository;
    public function __construct(UserRepository $userRepository)
    {
      $this->userRepository = $userRepository;
    }

    public function show(string $slug)
    {
      $user = $this->userRepository->findBySlug($slug);
      dd($user);
    }
}
