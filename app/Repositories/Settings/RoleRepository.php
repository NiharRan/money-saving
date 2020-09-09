<?php


namespace App\Repositories\Settings;


use App\Settings\Role;
use Yajra\DataTables\DataTables;

class RoleRepository
{
  protected $guarded = [];
  public function all()
  {
    return Role::orderBy('name', 'asc');
  }

  public function roleDataInTable()
  {
    try {
      return DataTables::of($this->all()->get())
        ->addColumn('status', function ($role) {
          $statusClass = $role->status == 1 ? 'icon-eye text-success' : 'icon-eye-off text-danger';
          return "<span class='m-auto'><i class='feather $statusClass'></i></span>";
        })
        ->addColumn('action', function ($role) {
          return '<a href="' . route('roles.edit', $role->id) . '" class="action-edit"><i class="feather icon-edit"></i></a>
                    <form class="display-inline-block" id="destroy_form" action="' . route('api.roles.destroy', $role->id) . '" method="post" onsubmit="return confirm(\'Are you sure?\')">
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

  public function findById($roleId)
  {
    return Role::find($roleId);
  }

  public function update($roleId)
  {
    $role = Role::find($roleId);
    return $role->update(request()->only('name'));
  }

  public function destroy($roleId)
  {
    return Role::find($roleId)->delete();
  }

  public function store()
  {
    return Role::create(request()->only('name'));
  }
}
