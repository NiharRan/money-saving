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
    return AccountType::orderBy('name', 'asc');
  }

  public function accountTypeDataInTable()
  {
    try {
      return DataTables::of($this->all()->get())
        ->addColumn('status', function ($accountType) {
          $statusClass = $accountType->status == 1 ? 'icon-eye text-success' : 'icon-eye-off text-danger';
          return "<span class='m-auto'><i class='feather $statusClass'></i></span>";
        })
        ->addColumn('action', function ($accountType) {
          return '<a href="' . route('account-types.edit', $accountType->id) . '" class="action-edit"><i class="feather icon-edit"></i></a>
                    <form class="display-inline-block" id="destroy_form" action="' . route('api.account-types.destroy', $accountType->id) . '" method="post" onsubmit="return confirm(\'Are you sure?\')">
                      <input type="hidden" name="_token" value="' . csrf_token() . '">
                      <input type="hidden" name="_method" value="DELETE">
                      <button class="normal-link" type="submit"><i class="feather icon-trash-2"></i></button>
                    </form>';
        })
        ->rawColumns([
          'name',
          'status',
          'action'
        ])->make(true);
    } catch (\Exception $e) {
      return $e->getMessage();
    }
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
