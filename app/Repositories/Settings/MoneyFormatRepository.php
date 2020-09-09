<?php


namespace App\Repositories\Settings;


use App\Settings\MoneyFormat;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;

class MoneyFormatRepository
{
  protected $guarded = [];
  public function all()
  {
    return MoneyFormat::orderBy('name', 'asc');
  }

  public function moneyFormatDataInTable()
  {
    try {
      return DataTables::of($this->all()->get())
        ->addColumn('status', function ($moneyFormat) {
          $statusClass = $moneyFormat->status == 1 ? 'icon-eye text-success' : 'icon-eye-off text-danger';
          return "<span class='m-auto'><i class='feather $statusClass'></i></span>";
        })
        ->addColumn('action', function ($moneyFormat) {
          return '<a href="' . route('money-formats.edit', $moneyFormat->id) . '" class="action-edit"><i class="feather icon-edit"></i></a>
                    <form class="display-inline-block" id="destroy_form" action="' . route('api.money-formats.destroy', $moneyFormat->id) . '" method="post" onsubmit="return confirm(\'Are you sure?\')">
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

  public function findById($moneyFormatId)
  {
    return MoneyFormat::find($moneyFormatId);
  }

  public function update($moneyFormatId)
  {
    $moneyFormat = MoneyFormat::find($moneyFormatId);
    return $moneyFormat->update([
      'name' => request()->name,
      'slug' => Str::slug(request()->name),
      'status' => request()->status
    ]);
  }

  public function destroy($moneyFormatId)
  {
    return MoneyFormat::find($moneyFormatId)->delete();
  }

  public function store()
  {
    return MoneyFormat::create([
      'name' => request()->name,
      'slug' => Str::slug(request()->name),
    ]);
  }
}
