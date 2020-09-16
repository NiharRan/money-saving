<?php

namespace App;

use App\Settings\Role;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','slug', 'father_name', 'mother_name', 'avatar', 'phone', 'email', 'gender_id', 'birth_date',
        'blood_group_id', 'religion_id', 'role_id', 'nationality',
        'password', 'email_verified_at', 'status'
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
      'role' => [
        "model" => \App\Settings\Role::class,
        'foreign_key' => 'role_id',
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
      'blood_group' => [
        "model" => \App\Users\BloodGroup::class,
        'foreign_key' => 'blood_group_id',
        'columns' => [
          'name' => [
            'searchable' => true,
            'orderable' => true,
          ],
        ],
      ],
    ],
  ];


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getIsSubscriberAttribute()
    {
      $role = Role::where('name', 'Subscriber')->first();
      return $role->id === $this->role_id;
    }
    public function getIsAdminAttribute()
    {
      $role = Role::where('name', 'Admin')->first();
      return $role->id === $this->role_id;
    }
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
      return route('users.profile', $this->slug);
    }
    public function getAvatarMediumAttribute()
    {
      return "/storage/profiles/thumbnail/medium/$this->avatar";
    }
    public function getAvatarSmallAttribute()
    {
      return "/storage/profiles/thumbnail/small/$this->avatar";
    }
    public function getAvatarOriginalAttribute()
    {
      return "/storage/profiles/thumbnail/$this->avatar";
    }

//    protected $appends = [
//      'current_status',
//      'last_updated',
//      'profile_url',
//      'avatar_small',
//      'avatar_medium',
//      'avatar_original',
//    ];

    public function scopeActive($query)
    {
      return $query->where('status', 1);
    }
    public function scopeAdmin($query)
    {
      $role = Role::where('name', 'Admin')->first();
      return $query->where('role_id', $role->id);
    }
    public function scopeSubscriber($query)
    {
      $role = Role::where('name', 'Subscriber')->first();
      return $query->where('role_id', $role->id);
    }

    public  function role() {
      return $this->belongsTo("App\Settings\Role");
    }
    public  function address() {
      return $this->hasOne("App\Users\Address");
    }
    public  function gender() {
      return $this->belongsTo("App\Users\Gender");
    }
    public  function blood_group() {
      return $this->belongsTo("App\Users\BloodGroup");
    }
    public  function religion() {
      return $this->belongsTo("App\Users\Religion");
    }

    public  function accounts() {
      return $this->belongsToMany("App\Account", "user_account")->withTimestamps();
    }

    public  function transactions() {
      return $this->hasMany("App\Transaction");
    }
}
