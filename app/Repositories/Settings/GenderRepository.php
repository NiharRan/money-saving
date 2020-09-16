<?php


namespace App\Repositories\Settings;


use App\Users\Gender;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;

class GenderRepository
{
  protected $guarded = [];
  public function all()
  {
    $rows = Gender::orderBy('name');
    if (request()->has('status')) {
      $rows = $rows->where('status', request()->status);
    }

    return $rows;
  }

  public function genderDataInTable()
  {
    try {
      return DataTables::of($this->all()->get())
        ->addColumn('status', function ($row) {
          $statusClass = $row->status == 1 ? 'icon-eye text-success' : 'icon-eye-off text-danger';
          return "<span class='m-auto'><i class='feather $statusClass'></i></span>";
        })
        ->addColumn('action', function ($row) {
          return '<a href="' . route('genders.edit', $row->id) . '" class="action-edit"><i class="feather icon-edit"></i></a>
                    <form class="display-inline-block" id="destroy_form" action="' . route('api.genders.destroy', $row->id) . '" method="post" onsubmit="return confirm(\'Are you sure?\')">
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

  public function findById($rowId)
  {
    return Gender::find($rowId);
  }

  public function update($rowId)
  {
    $row = Gender::find($rowId);
    return $row->update([
      'name' => request()->name,
      'slug' => Str::slug(request()->name),
      'status' => request()->status
    ]);
  }

  public function destroy($rowId)
  {
    return Gender::find($rowId)->delete();
  }

  public function store()
  {
    return Gender::create([
      'name' => request()->name,
      'slug' => Str::slug(request()->name)
    ]);
  }
}
