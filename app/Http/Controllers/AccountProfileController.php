<?php

namespace App\Http\Controllers;

use App\Repositories\AccountRepository;
use App\Settings\TransactionType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AccountProfileController extends Controller
{
    protected $accountRepository;
    public function __construct(AccountRepository $accountRepository)
    {
      $this->accountRepository = $accountRepository;
    }

    public function show(string $slug)
    {
      $account = $this->accountRepository->findBySlug($slug);
      $transactionTypes = $this->accountRepository->transactionsByType($account);

      $users = $account->users;
      foreach ($users as $key => $user) {
        $users[$key]->transactionTypes = $this->accountRepository->transactionsByType($account, $user->id);
      }
      $pageConfigs = [
        'pageHeader' => true
      ];
      $breadcrumbs = [
        ['link'=>"/",'name'=> __("Home")],
        ['name'=> $account->name],
      ];
      $config = [
        'text' => __(''),
        'vue' => true,
      ];
      return view('/pages/accounts/profile', [
        'breadcrumbs' => $breadcrumbs,
        'config' => $config,
      ]);
    }
}
