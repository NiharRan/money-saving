<?php

namespace App\Http\Controllers;

use App\Repositories\AccountRepository;
use Illuminate\Http\Request;

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
      $pageConfigs = [
        'pageHeader' => true
      ];
      $breadcrumbs = [
        ['link'=>"/",'name'=>"Home"],
        ['name'=> $account->name],
      ];
      return view('/pages/accounts/profile', [
        'breadcrumbs' => $breadcrumbs
      ])->with([
        'account' => $account
      ]);
    }
}
