<?php


namespace App\Repositories;


use App\Customer;
use Illuminate\Http\Request;
use JamesDordoy\LaravelVueDatatable\Http\Resources\DataTableCollectionResource;
use Intervention\Image\Facades\Image;

class CustomerRepository
{
  public function all()
  {
    $rows = Customer::with([
      'gender',
      'religion',
      'account',
      'upazilla',
      'district',
      'division'
    ])->orderBy('name');

    if (\request()->has('status')) {
      $rows = $rows->where('status', 1);
    }

    return $rows;
  }

  public function findById($rowId)
  {
    return Customer::with([
      'gender',
      'religion',
      'account',
      'upazilla',
      'district',
      'division'
    ])->find($rowId);
  }

  public function findBySlug(string $slug)
  {
    return Customer::with([
      'gender',
      'religion',
      'account',
      'upazilla',
      'district',
      'division'
    ])->where('slug', $slug)
      ->first();
  }

  public function dataTable(Request $request)
  {
    $query = Customer::eloquentQuery(
      $request->input('column'),
      $request->input('dir'),
      $request->input('search'),
      [
        "gender",
        "account",
        "religion",
        "division",
        "district",
        "upazilla"
      ]
    );

    if (auth()->user()->isSubscriber) {
      $userId = auth()->user()->id;
      $query = $query->whereHas('account.users', function ($q) use ($userId) {
        $q->where('users.id', $userId);
      });
    }
    $data = $query->paginate($request->input('length'));

    return new DataTableCollectionResource($data);
  }

  public function store($request)
  {
    $customer = new Customer;
    $customer = $this->setupData($customer, $request);
    $customer->created_at = date('Y-m-d H:i:s');
    return $customer;
  }

  public function update($request, $id)
  {
    $customer = $this->findById($id);
    $customer = $this->setupData($customer, $request);
    if ($customer->save()) {
      return $customer;
     }
    return null;
  }

  public function setupData(Customer $customer, $request)
  {
    $customer->name = $request->name;
    $customer->slug = make_slug($request->name);
    $customer->phone = $request->phone;
    $customer->email = $request->email;
    $customer->account_id = $request->account_id;
    $customer->gender_id = $request->gender_id;
    $customer->religion_id = $request->religion_id;
    $customer->division_id = $request->division_id;
    $customer->district_id = $request->district_id;
    $customer->upazilla_id = $request->upazilla_id;
    $customer->address = $request->address;

    return $customer;
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
      $request->file('avatar')->storeAs('public/customers', $fileNameToStore);
      $request->file('avatar')->storeAs('public/customers/thumbnail/small', $fileNameToStore);
      $request->file('avatar')->storeAs('public/customers/thumbnail/medium', $fileNameToStore);

      //create small thumbnail
      $smallThumbnailPath = public_path('storage/customers/thumbnail/small/'.$fileNameToStore);
      $this->createThumbnail($smallThumbnailPath, 150, 93);

      //create medium thumbnail
      $mediumThumbnailPath = public_path('storage/customers/thumbnail/medium/'.$fileNameToStore);
      $this->createThumbnail($mediumThumbnailPath, 300, 185);
    }
}
