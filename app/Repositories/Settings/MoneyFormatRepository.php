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
    $money_formats = MoneyFormat::orderBy('name', 'asc');
    if (request()->has('status')) {
      $money_formats = $money_formats->where('status', request()->status);
    }
    return $money_formats;
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
