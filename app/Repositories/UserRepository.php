<?php


namespace App\Repositories;


use App\Settings\TransactionType;
use App\User;
use App\Users\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use JamesDordoy\LaravelVueDatatable\Http\Resources\DataTableCollectionResource;
use Intervention\Image\Facades\Image;

class UserRepository
{

  protected $guarded = [];
  public function all()
  {
    $users = User::with([
      'gender',
      'religion',
      'blood_group',
      'role',
    ])->where('id', '!=', auth()->user()->id);

    if (\request()->has('status')) {
      $users = $users->where('status', \request()->status);
    }

    if (\request()->has('slug')) {
      $users = $users->where('slug', \request()->slug);
    }

    if (\request()->has('role')) {
      $role = \request()->role;
      $users = $users->whereHas('role', function ($q) use ($role) {
        $q->where('name', $role);
      });
    }
    return $users->orderBy('name', 'asc');
  }

  public function findById($rowId)
  {
    return User::with([
      'gender',
      'religion',
      'blood_group',
      'role',
      'accounts',
      'address' => function ($query) {
        $query->with([
          'upazilla',
          'district',
          'division'
        ]);
      },
    ])->find($rowId);
  }

  public function findBySlug(string $slug)
  {
    return User::with([
      'gender',
      'religion',
      'blood_group',
      'role',
      'accounts',
      'address' => function ($query) {
        $query->with([
          'upazilla',
          'district',
          'division'
        ]);
      },
    ])->where('slug', $slug)
      ->first();
  }

  public function store(Request $request)
  {
    $user = new User;
    $user = $this->setupData($user, $request);
    $user->email_verified_at = date('Y-m-d H:i:s');
    $user->password = Hash::make("12345678");
    $user->created_at = date('Y-m-d H:i:s');
    if ($user->save()) {
      $address = $user->address();
      $address = $this->setupAddress($address, $request);
      $address->created_at = date('Y-m-d H:i:s');
      if ($address->save()) {
        return $user;
      }
    }
    return null;
  }

  public function update(Request $request, $id)
  {
    $user = $this->findById($id);
    $this->setupData($user, $request);
    if ($user->save()) {
      $address = $user->address;
      $address = $this->setupAddress($address, $request);
      if ($address->save()) {
        return $user;
      }
    }
    return null;
  }

  private function setupData(User $user, $request)
  {
    $user->name = $request->name;
    $user->slug = make_slug($request->name);
    $user->father_name = $request->father_name;
    $user->mother_name = $request->mother_name;
    $user->phone = $request->phone;
    $user->email = $request->email;
    $user->gender_id = $request->gender_id;
    $user->birth_date = date('Y-m-d', strtotime($request->birth_date));
    $user->blood_group_id = $request->blood_group_id;
    $user->religion_id = $request->religion_id;
    $user->nationality = $request->nationality;
    return $user;
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

  public function transactionAmountByType($user, $account = null)
  {
    $transactionTypes = TransactionType::active()->orderBy('name', 'asc')->get();
    foreach ($transactionTypes as  $key => $transactionType) {
      $query = DB::table('transactions')
        ->where('transaction_type_id', '=', $transactionType->id)
        ->where('user_id', '=', $user->id);
      if ($account != null) {
        $query = $query->where('account_id', '=', $account->id)
          ->where('created_at', '>=', $account->created_at);
      }
      $transactionTypes[$key]->amount = $query->sum('amount');
    }
    return $transactionTypes;
  }

  public function accounts($userId)
  {
    $accounts = $this->findById($userId)->accounts;
    if (\request()->has('status')) {
      $accounts = $accounts->where('status', \request()->status);
    }
    return $accounts;
  }

    public function dataTable(Request $request)
    {
      $query = User::eloquentQuery(
        $request->input('column'),
        $request->input('dir'),
        $request->input('search'),
        [
          "gender",
          "role",
          "religion",
          "blood_group",
        ]
      );

      $userId = auth()->user()->id;
      $query = $query->where('id', '!=', $userId);

      $data = $query->paginate($request->input('length'));

      return new DataTableCollectionResource($data);
    }

  private function setupAddress(Address $address, Request $request)
  {
    $address->address = $request->address;
    $address->division_id = $request->division_id;
    $address->district_id = $request->district_id;
    $address->upazilla_id = $request->upazilla_id;
    return $address;
  }

  public function uploadImage(string $fileNameToStore, $request)
  {
    $request->file('avatar')->storeAs('public/users', $fileNameToStore);
    $request->file('avatar')->storeAs('public/users/thumbnail/small', $fileNameToStore);
    $request->file('avatar')->storeAs('public/users/thumbnail/medium', $fileNameToStore);

    //create small thumbnail
    $smallThumbnailPath = public_path('storage/users/thumbnail/small/'.$fileNameToStore);
    $this->createThumbnail($smallThumbnailPath, 150, 93);

    //create medium thumbnail
    $mediumThumbnailPath = public_path('storage/users/thumbnail/medium/'.$fileNameToStore);
    $this->createThumbnail($mediumThumbnailPath, 300, 185);
  }


}
