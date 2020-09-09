<?php


namespace App\Repositories\Settings;


use App\Settings\TransactionType;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;

class TransactionTypeRepository
{
  protected $guarded = [];
  public function all()
  {
    return TransactionType::orderBy('name', 'asc');
  }

  public function transactionTypeDataInTable()
  {
    try {
      return DataTables::of($this->all()->get())
        ->addColumn('status', function ($transactionType) {
          $statusClass = $transactionType->status == 1 ? 'icon-eye text-success' : 'icon-eye-off text-danger';
          return "<span class='m-auto'><i class='feather $statusClass'></i></span>";
        })
        ->addColumn('action', function ($transactionType) {
          return '<a href="' . route('transaction-types.edit', $transactionType->id) . '" class="action-edit"><i class="feather icon-edit"></i></a>
                    <form class="display-inline-block" id="destroy_form" action="' . route('api.transaction-types.destroy', $transactionType->id) . '" method="post" onsubmit="return confirm(\'Are you sure?\')">
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

  public function findById($transactionTypeId)
  {
    return TransactionType::find($transactionTypeId);
  }

  public function update($transactionTypeId)
  {
    $transactionType = TransactionType::find($transactionTypeId);
    return $transactionType->update([
      'name' => request()->name,
      'slug' => Str::slug(request()->name),
      'status' => request()->status
    ]);
  }

  public function destroy($transactionTypeId)
  {
    return TransactionType::find($transactionTypeId)->delete();
  }

  public function store()
  {
    return TransactionType::create([
      'name' => request()->name,
      'slug' => Str::slug(request()->name),
    ]);
  }
}
