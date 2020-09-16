<?php

namespace App;

use JamesDordoy\LaravelVueDatatable\Traits\LaravelVueDatatableTrait;

class Customer extends MyModel
{
  use LaravelVueDatatableTrait;
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'name','slug', 'avatar', 'phone', 'email', 'account_id', 'gender_id', 'religion_id',
    'division_id', 'district_id', 'upazilla_id', 'address', 'status'
  ];

  protected $dates = [
    'created_at',
    'updated_at',
  ];

  protected $dataTableColumns = [
    'id' => [
      'searchable' => false,
    ],
    'name' => [
      'searchable' => true,
    ],
    'phone' => [
      'searchable' => true,
    ],
    'email' => [
      'searchable' => true,
    ],
    'address' => [
      'searchable' => true,
    ],
    'avatar' => [
      'searchable' => false
    ]
  ];
  protected $dataTableRelationships = [
    "belongsTo" => [
      'gender' => [
        "model" => \App\Users\Gender::class,
        'foreign_key' => 'gender_id',
        'columns' => [
          'name' => [
            'searchable' => true,
            'orderable' => true,
          ],
        ],
      ],
      'account' => [
        "model" => \App\Account::class,
        'foreign_key' => 'account_id',
        'columns' => [
          'name' => [
            'searchable' => true,
            'orderable' => true,
          ],
        ],
      ],
      'religion' => [
        "model" => \App\Users\Religion::class,
        'foreign_key' => 'religion_id',
        'columns' => [
          'name' => [
            'searchable' => true,
            'orderable' => true,
          ],
        ],
      ],
      'division' => [
        "model" => \App\Settings\Division::class,
        'foreign_key' => 'division_id',
        'columns' => [
          'name' => [
            'searchable' => true,
            'orderable' => true,
          ],
        ],
      ],
      'district' => [
        "model" => \App\Settings\District::class,
        'foreign_key' => 'district_id',
        'columns' => [
          'name' => [
            'searchable' => true,
            'orderable' => true,
          ],
        ],
      ],
      'upazilla' => [
        "model" => \App\Settings\Upazilla::class,
        'foreign_key' => 'upazilla_id',
        'columns' => [
          'name' => [
            'searchable' => true,
            'orderable' => true,
          ],
        ],
      ],
    ],
  ];


  public function getLastUpdatedAttribute()
  {
    return $this->updated_at->diffForHumans();
  }
  public function getCurrentStatusAttribute()
  {
    return $this->status == 1 ? 'Active' : 'Not Active';
  }
  public function getProfileUrlAttribute()
  {
    return route('customers.profile', $this->slug);
  }
  public function getAvatarMediumAttribute()
  {
    return "/storage/customers/thumbnail/medium/$this->avatar";
  }
  public function getAvatarSmallAttribute()
  {
    return "/storage/customers/thumbnail/small/$this->avatar";
  }
  public function getAvatarOriginalAttribute()
  {
    return "/storage/customers/$this->avatar";
  }

  public  function division() {
    return $this->belongsTo("App\Settings\Division");
  }
  public  function district() {
    return $this->belongsTo("App\Settings\District");
  }
  public  function gender() {
    return $this->belongsTo("App\Users\Gender");
  }
  public  function upazilla() {
    return $this->belongsTo("App\Settings\Upazilla");
  }
  public  function religion() {
    return $this->belongsTo("App\Users\Religion");
  }

  public  function account() {
    return $this->belongsTo("App\Account");
  }

  public  function loans() {
    return $this->hasMany("App\Loan");
  }
}
