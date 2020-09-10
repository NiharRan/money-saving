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
      $transactionTypes = $this->userRepository->transactionAmountByType($user);
      $accounts = $user->accounts;
      foreach ($accounts as $key => $account) {
        $accounts[$key]->transactionTypes = $this->userRepository->transactionAmountByType($user, $account);
      }
      $pageConfigs = [
        'pageHeader' => true
      ];
      $breadcrumbs = [
        ['link'=>"/",'name'=>"Home"],
        ['name'=> $user->name],
      ];
    return view('/pages/users/profile', [
        'breadcrumbs' => $breadcrumbs
      ])->with([
        'user' => $user,
        'transactionTypes' => $transactionTypes,
        'accounts' => $accounts
      ]);
    }
}
