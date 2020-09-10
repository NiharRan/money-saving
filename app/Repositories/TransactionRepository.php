<?php


namespace App\Repositories;


use App\Transaction;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;

class TransactionRepository
{
  protected $guarded = [];
  public function all()
  {
    return Transaction::with([
        'user',
        'transaction_type',
        'account'
    ])->orderBy('name', 'asc');
  }

  public function transactionDataInTable()
  {
    try {
      return DataTables::of($this->all()->get())
        ->addColumn('status', function ($transaction) {
          $statusClass = $transaction->status == 1 ? 'icon-eye text-success' : 'icon-eye-off text-danger';
          return "<span class='m-auto'><i class='feather $statusClass'></i></span>";
        })
        ->addColumn('action', function ($transaction) {
          return '<a href="' . route('account-types.edit', $transaction->id) . '" class="action-edit"><i class="feather icon-edit"></i></a>
                    <form class="display-inline-block" id="destroy_form" action="' . route('api.account-types.destroy', $transaction->id) . '" method="post" onsubmit="return confirm(\'Are you sure?\')">
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

  public function userTransactionsDataInTable(int $userId)
  {
    try {
      return DataTables::of($this->findByUser($userId))
        ->addColumn('invoice', function ($transaction) {
          $subStr = strtoupper(substr($transaction->user->name, 0, 3));
          $invoice = $subStr . '-' . sprintf("%'.03d\n", $transaction->invoice);
          return '<p class="text-center"><strong>'.$invoice.'</strong></p>';
        })
        ->addColumn('amount', function ($transaction) {
          return '<p class="text-right"><strong>'.$transaction->amount.'</strong></p>';
        })
        ->addColumn('status', function ($transaction) {
          $statusClass = $transaction->status == 1 ? 'icon-check-square text-success' : 'icon-x text-danger';
          return "<p class='text-center'><span class='m-auto'><i class='feather $statusClass'></i></span></p>";
        })
        ->rawColumns([
          'invoice',
          'amount',
          'status',
        ])->make(true);
    } catch (\Exception $e) {
      return $e->getMessage();
    }
  }

  public function accountTransactionsDataInTable($accountId)
  {
      try {
          return DataTables::of($this->findByAccount($accountId))
          ->addColumn('invoice', function ($transaction) {
              $subStr = strtoupper(substr($transaction->user->name, 0, 3));
              $invoice = $subStr . '-' . sprintf("%'.03d\n", $transaction->invoice);
              return '<p class="text-center"><strong>'.$invoice.'</strong></p>';
          })
          ->addColumn('amount', function ($transaction) {
            return '<p class="text-right"><strong>'.$transaction->amount.'</strong></p>';
            })
          ->addColumn('status', function ($transaction) {
            $statusClass = $transaction->status == 1 ? 'icon-check-square text-success' : 'icon-x text-danger';
            return "<p class='text-center'><span class='m-auto'><i class='feather $statusClass'></i></span></p>";
          })
          ->rawColumns([
            'invoice',
            'amount',
            'status',
          ])->make(true);
      } catch (\Exception $e) {
          return $e->getMessage();
      }
  }

  public function findByAccount($accountId)
  {
    return Transaction::with([
        'user',
        'transaction_type',
    ])->where('account_id', $accountId)->get();
  }

  private function findByUser(int $userId)
  {
    return Transaction::with([
      'account',
      'transaction_type',
    ])->where('user_id', $userId)->get();
  }

  public function findById($transactionId)
  {
    return Transaction::find($transactionId);
  }

  public function update($transactionId)
  {
    $transaction = Transaction::find($transactionId);
    return $transaction->update([
      'name' => request()->name,
      'slug' => Str::slug(request()->name),
      'status' => request()->status
    ]);
  }

  public function destroy($transactionId)
  {
    return Transaction::find($transactionId)->delete();
  }

  public function store()
  {
      $user_id = request()->user_id;
      $transaction = Transaction::where('user_id', $user_id)->orderBy('invoice', 'desc')->first();
      $invoice = $transaction ? $transaction->invoice + 1 : 1;
    return Transaction::create([
        'invoice' => $invoice,
        'account_id' => request()->account_id,
        'user_id' => $user_id,
        'transaction_type_id' => request()->transaction_type_id,
        'amount' => request()->amount,
        'created_at' => date('Y-m-d H:i:s')
    ]);
  }
}
