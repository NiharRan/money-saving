<?php
namespace App\Repositories;

use App\Account;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;

class AccountRepository
{

  protected $guarded = [];
  public function all()
  {
    return Account::with([
      'account_type',
      'money_format',
      'users',
    ])->orderBy('name', 'asc');
  }

  public function findById($rowId)
  {
    return Account::with([
      'account_type',
      'money_format',
      'users',
    ])->find($rowId);
  }

  public function findBySlug(string $slug)
  {
    return Account::with([
      'account_type',
    ])->where('slug', $slug)
      ->first();
  }

  public function accountDataInTable()
  {
    try {
      return DataTables::of($this->all()->get())
        ->addColumn('name', function ($account) {
          return '<div class="d-flex align-items-center">
                     <div class="avatar p-0 m-0">
                        <div class="avatar-content small">
                            <a href="' . $account->profileUrl . '">
                                <img style="width:100%" src="' . $account->logoSmall . '" alt="' . $account->name . '">
                            </a>
                        </div>
                    </div>
                    <div class="info ml-2">
                        <a class="text-primary" href="' . $account->profileUrl . '">' . $account->name . '</a>
                        <p class="mb-0 pb-0 text-bold"><small>' . $account->account_type->name . '</small></p>
                    </div>
                  </div>';
        })
        ->addColumn('status', function ($account) {
          $statusClass = $account->status == 1 ? 'icon-eye text-success' : 'icon-eye-off text-danger';
          return "<span class='m-auto'><i class='feather $statusClass'></i></span>";
        })
        ->addColumn('action', function ($account) {
          return '<a href="' . route('accounts.edit', $account->id) . '" class="action-edit"><i class="feather icon-edit"></i></a>
                    <form class="display-inline-block" id="destroy_form" action="' . route('api.accounts.destroy', $account->id) . '" method="post" onsubmit="return confirm(\'Are you sure?\')">
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

  public function store()
  {
    $account = Account::create([
      'name' => request()->name,
      'slug' => Str::slug(request()->name),
      'slugan' => request()->slugan,
      'account_type_id' => request()->account_type_id,
      'money_format_id' => request()->money_format_id,
    ]);
    $users = empty(request()->users) ? [] : explode(',', request()->users);
    $users[] = auth()->user()->id;
    if ($account) {
      $account->users()->sync($users);
    }
    return $account;
  }

  public function update($accountId)
  {
    $account = Account::find($accountId);
    $account->name = request()->name;
    $account->slug = Str::slug(request()->name);
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
}