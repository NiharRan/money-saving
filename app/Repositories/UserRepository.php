<?php


namespace App\Repositories;


use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;

class UserRepository
{

  protected $guarded = [];
  public function all()
  {
    return User::with([
      'gender',
      'religion',
      'blood_group',
      'role',
    ])->orderBy('name', 'asc');
  }

  public function findById($rowId)
  {
    return User::with([
      'gender',
      'religion',
      'blood_group',
      'role',
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

  public function userDataInTable()
  {
    try {
      return DataTables::of($this->all()->get())
        ->addColumn('name', function ($user) {
          return '<div class="d-flex align-items-center">
                     <div class="avatar p-0 m-0">
                        <div class="avatar-content small">
                            <a href="' . $user->profileUrl . '">
                                <img style="width:100%" src="' . $user->avatarSmall . '" alt="' . $user->name . '">
                            </a>
                        </div>
                    </div>
                    <div class="info ml-2">
                        <a class="text-primary" href="' . $user->profileUrl . '">' . $user->name . '</a>
                        <p class="mb-0 pb-0 text-bold"><small>' . $user->role->name . '</small></p>
                    </div>
                  </div>';
        })
        ->addColumn('status', function ($user) {
          $statusClass = $user->status == 1 ? 'icon-eye text-success' : 'icon-eye-off text-danger';
          return "<span class='m-auto'><i class='feather $statusClass'></i></span>";
        })
        ->addColumn('action', function ($user) {
          return '<a href="' . route('users.edit', $user->id) . '" class="action-edit"><i class="feather icon-edit"></i></a>
                  <a title="See all courses of ' . $user->name . '" href="" target="_blank" class="action-list"><i class="feather icon-list"></i></a>
                    <form class="display-inline-block" id="destroy_form" action="' . route('api.users.destroy', $user->id) . '" method="post" onsubmit="return confirm(\'Are you sure?\')">
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

  public function store(Request $request)
  {
    $row = User::create([
      'name' => $request->name,
      'slug' => Str::slug($request->name),
      'father_name' => $request->father_name,
      'mother_name' => $request->mother_name,
      'phone' => $request->phone,
      'email' => $request->email,
      'gender_id' => $request->gender_id,
      'birth_date' => $request->birth_date,
      'blood_group_id' => $request->blood_group_id,
      'religion_id' => $request->religion_id,
      'role_id' => 1,
      'nationality' => $request->nationality,
      'email_verified_at' => date('Y-m-d H:i:s'),
      'password' => Hash::make("12345678"),
      'created_at' => date('Y-m-d H:i:s')
    ]);
    $row->address()->create([
      'address' => $request->address,
      'division_id' => $request->division_id,
      'district_id' => $request->district_id,
      'upazilla_id' => $request->upazilla_id,
      'created_at' => date('Y-m-d H:i:s'),
      'updated_at' => date('Y-m-d H:i:s'),
    ]);
    return $row;
  }

  public function update(Request $request, $id)
  {
    $user = $this->findById($id);
    $user->name = $request->name;
    $user->slug = Str::slug($request->name);
    $user->father_name = $request->father_name;
    $user->mother_name = $request->mother_name;
    $user->phone = $request->phone;
    $user->email = $request->email;
    $user->gender_id = $request->gender_id;
    $user->birth_date = date('Y-m-d', strtotime($request->birth_date));
    $user->blood_group_id = $request->blood_group_id;
    $user->religion_id = $request->religion_id;
    $user->nationality = $request->nationality;
    if ($user->save()) {
      $address = $user->address;
      $address->address = $request->address;
      $address->division_id = $request->division_id;
      $address->district_id = $request->district_id;
      $address->upazilla_id = $request->upazilla_id;
      if($address->save()) {
        return $user;
      }
     }
    return null;
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
