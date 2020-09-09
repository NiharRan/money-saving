<?php

namespace App\Http\Controllers;

use App\Repositories\AccountRepository;
use App\Settings\AccountType;
use App\Settings\MoneyFormat;
use App\User;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    protected $accountRepository;
    public function __construct(AccountRepository $accountRepository)
    {
      $this->accountRepository = $accountRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $pageConfigs = [
          'pageHeader' => true
        ];
        $breadcrumbs = [
          ['link'=>"/",'name'=>"Home"],
          ['name'=>"Accounts"],
        ];
        return view('/pages/accounts/index', [
          'breadcrumbs' => $breadcrumbs
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $accountTypes = AccountType::active()->orderBy('name', 'ASC')->get();
        $moneyFormats = MoneyFormat::active()->orderBy('name', 'ASC')->get();
        $users = User::subscriber()
              ->active()
            ->where('id', '!=', Auth::id())
          ->orderBy('name', 'ASC')
        ->get();

        $breadcrumbs = [
            ['link'=>"/",'name'=>"Home"],
            ['link'=>"/accounts",'name'=>"Accounts"],
            ['link'=>"",'name'=>"Create New Account"],
          ];
          return view('/pages/accounts/create', [
            'breadcrumbs' => $breadcrumbs
          ])->with([
              'accountTypes' => $accountTypes,
              'moneyFormats' => $moneyFormats,
              'users' => $users,
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
      $account = $this->accountRepository->findById($id);
      $subscribedUsers = []; 
      if ($account->joinAccount()) {
        $account->users->map(function ($user) use (&$subscribedUsers) {
          $subscribedUsers[] = $user->id;
        });
      } 
      $account->subscribedUsers = $subscribedUsers;
      $accountTypes = AccountType::active()->orderBy('name', 'ASC')->get();
      $moneyFormats = MoneyFormat::active()->orderBy('name', 'ASC')->get();
      $users = User::subscriber()
            ->active()
          ->where('id', '!=', Auth::id())
        ->orderBy('name', 'ASC')
      ->get();

      $breadcrumbs = [
          ['link'=>"/",'name'=>"Home"],
          ['link'=>"/accounts",'name'=>"Accounts"],
          ['link'=>"",'name'=>"Edit $account->name's Info"],
        ];
        return view('/pages/accounts/edit', [
          'breadcrumbs' => $breadcrumbs
        ])->with([
            'accountTypes' => $accountTypes,
            'moneyFormats' => $moneyFormats,
            'users' => $users,
            'account' => $account,
        ]);
    }
}
