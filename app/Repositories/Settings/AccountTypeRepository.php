<?php


namespace App\Repositories\Settings;


use App\Settings\AccountType;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;

class AccountTypeRepository
{
  protected $guarded = [];
  public function all()
  {
    $account_types = AccountType::orderBy('name', 'asc');
    if (request()->has('status')) {
      $account_types = $account_types->where('status', request()->status);
    }
    return $account_types;
  }


  public function findById($accountTypeId)
  {
    return AccountType::find($accountTypeId);
  }

  public function update($accountTypeId)
  {
    $accountType = AccountType::find($accountTypeId);
    return $accountType->update([
      'name' => request()->name,
      'slug' => Str::slug(request()->name),
      'status' => request()->status
    ]);
  }

  public function destroy($accountTypeId)
  {
    return AccountType::find($accountTypeId)->delete();
  }

  public function store()
  {
    return AccountType::create([
      'name' => request()->name,
      'slug' => Str::slug(request()->name)
    ]);
  }
}
