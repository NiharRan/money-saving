<?php
namespace App\Repositories;

use App\Account;
use App\Settings\TransactionType;
use App\Transaction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use JamesDordoy\LaravelVueDatatable\Http\Resources\DataTableCollectionResource;
use Intervention\Image\Facades\Image;

class AccountRepository
{

  protected $guarded = [];

  /**
   * @return Builder
   */
  public function all()
  {
    $accounts = Account::with([
      'account_type',
      'money_format',
      'users',
    ])->orderBy('name', 'asc');

    if (request()->has('status')) {
      $accounts = $accounts->where('status', request()->status);
    }
    return $accounts;
  }

  /**
   * @param $rowId
   * @return Builder|Builder[]|Collection|Model|null
   */
  public function findById($rowId)
  {
    return Account::with([
      'account_type',
      'money_format',
      'users',
    ])->find($rowId);
  }

  /**
   * @param string $slug
   * @return Builder|Model|object|null
   */
  public function findBySlug(string $slug)
  {
    return Account::with([
      'account_type',
    ])->where('slug', $slug)
      ->first();
  }

  /**
   * @return string
   */
  public function dataTable(Request $request)
  {
    $query = Account::eloquentQuery(
      $request->input('column'),
      $request->input('dir'),
      $request->input('search'),
      [
        "account_type",
        "money_format",
        "users",
      ]
    );

    if (auth()->user()->isSubscriber) {
      $userId = auth()->user()->id;
      $query = $query->whereHas('users', function ($q) use ($userId) {
        $q->where('users.id', $userId);
      });
    }
    $data = $query->paginate($request->input('length'));

    return new DataTableCollectionResource($data);
  }

  /**
   * @return mixed
   */
  public function store()
  {
    $account = new Account;
    return $this->setupData($account);
  }

  /**
   * @param $accountId
   * @return mixed
   */
  public function update($accountId)
  {
    $account = Account::find($accountId);
    return $this->setupData($account);
  }

  public function setupData(Account $account)
  {
    $account->name = request()->name;
    $account->slug = make_slug(request()->name);
    $account->slugan = request()->slugan;
    $account->account_type_id = request()->account_type_id;
    $account->money_format_id = request()->money_format_id;
    $users = empty(request()->users) ? [] : explode(',', request()->users);
    $users[] = auth()->user()->id;
    if ($account->save()) {
      $account->users()->sync($users);
    }
    return $account;
  }

  /**
   * Create a thumbnail of specified size
   *
   * @param string $path path of thumbnail
   * @param int $width
   * @param int $height
   */
  public function createThumbnail($path, $width, $height)
  {
    $img = Image::make($path)->resize($width, $height, function ($constraint) {
      $constraint->aspectRatio();
    });
    $img->save($path);
  }


  public function uploadImage(string $fileNameToStore, $request)
  {
    $request->file('logo')->storeAs('public/accounts', $fileNameToStore);
    $request->file('logo')->storeAs('public/accounts/thumbnail/small', $fileNameToStore);
    $request->file('logo')->storeAs('public/accounts/thumbnail/medium', $fileNameToStore);

    //create small thumbnail
    $smallThumbnailPath = public_path('storage/accounts/thumbnail/small/'.$fileNameToStore);
    $this->createThumbnail($smallThumbnailPath, 150, 93);

    //create medium thumbnail
    $mediumThumbnailPath = public_path('storage/accounts/thumbnail/medium/'.$fileNameToStore);
    $this->createThumbnail($mediumThumbnailPath, 300, 185);
  }

  public function users($accountId)
  {
    $users = $this->findById($accountId)->users;
    if (\request()->has('status')) {
      $users = $users->where('status', \request()->status);
    }
    return $users;
  }
  /**
   * @param Account $account
   * @param null $user_id
   * @return mixed
   */
  public function transactionsByType($account, $user_id=null)
  {
    $transactionTypes = TransactionType::active()->orderBy('name', 'asc')->get();
    foreach ($transactionTypes as $key => $transactionType) {
      $query = DB::table('transactions')
        ->where('account_id', '=', $account->id)
        ->where('created_at', '>=', $account->created_at)
        ->where('transaction_type_id', '=', $transactionType->id);
      if ($user_id !==  null) {
        $query = $query->where('user_id', '=', $user_id);
      }
      $transactionTypes[$key]->amount = $query->sum('amount');
    }
    return $transactionTypes;
  }
}
