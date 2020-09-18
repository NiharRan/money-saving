<?php


namespace App\Repositories;


use App\Transaction;
use Illuminate\Http\Request;
use JamesDordoy\LaravelVueDatatable\Http\Resources\DataTableCollectionResource;

class TransactionRepository
{
  protected $guarded = [];
  public function all()
  {
    return Transaction::with([
        'user',
        'transaction_type',
        'account' => function ($query) {
          return $query->orderBy('name');
        }
    ]);

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

  public function store()
  {
    $user_id = request()->user_id;
    $transaction = Transaction::where('user_id', $user_id)->orderBy('invoice', 'desc')->first();
    $invoice = $transaction ? $transaction->invoice + 1 : 1;

    $transaction = new Transaction;
    $transaction->invoice = $invoice;

    $transaction = $this->setupData($transaction);
    $transaction->created_at = date('Y-m-d H:i:s');

    return $transaction->save();
  }


  public function update($transactionId)
  {
    $transaction = Transaction::find($transactionId);
    $transaction = $this->setupData($transaction);

    return $transaction->save();
  }

  public function setupData(Transaction $transaction)
  {
    $transaction->account_id = request()->account_id;
    $transaction->user_id = request()->user_id;
    $transaction->received_by = auth()->user()->id;
    $transaction->amount = request()>amount;
    $transaction->trans_date = date('Y-m-d', strtotime(request()->trans_date));

    return $transaction;
  }

  public function destroy($transactionId)
  {
    return Transaction::find($transactionId)->delete();
  }

  public function dataTable(Request $request)
  {
    $query = Transaction::eloquentQuery(
      $request->input('column'),
      $request->input('dir'),
      $request->input('search'),
      [
        "user",
        "account",
        "transaction_type",
      ]
    );

    if (auth()->user()->isSubscriber) {
      $userId = auth()->user()->id;
      $query = $query->where('transactions.user_id', $userId);
    }
    $data = $query->paginate($request->input('length'));

    return new DataTableCollectionResource($data);
  }
  public function accountTransactionDataTable(Request $request, $slug)
  {
    $query = Transaction::eloquentQuery(
      $request->input('column'),
      $request->input('dir'),
      $request->input('search'),
      [
        "user",
        "account",
        "transaction_type",
      ]
    );

    $query = $query->whereHas('account', function ($q) use ($slug) {
      $q->where('accounts.slug', $slug);
    });
    $data = $query->paginate($request->input('length'));

    return new DataTableCollectionResource($data);
  }

  public function userTransactionDataTable(Request $request, $slug)
  {
    $query = Transaction::eloquentQuery(
      $request->input('column'),
      $request->input('dir'),
      $request->input('search'),
      [
        "user",
        "account",
        "transaction_type",
      ]
    );

    $query = $query->whereHas('user', function ($q) use ($slug) {
      $q->where('users.slug', $slug);
    });
    $data = $query->paginate($request->input('length'));

    return new DataTableCollectionResource($data);
  }


}
