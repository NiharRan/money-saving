<?php

namespace App;

use App\Settings\AccountType;
use JamesDordoy\LaravelVueDatatable\Traits\LaravelVueDatatableTrait;

class Account extends MyModel
{
    use LaravelVueDatatableTrait;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'slug', 'logo', 'slugan', 'account_type_id', 'money_format_id'
    ];

  protected $dataTableColumns = [
    'id' => [
      'searchable' => false,
    ],
    'name' => [
      'searchable' => true,
    ],
    'slugan' => [
      'searchable' => false,
    ],
    'logo' => [
      'searchable' => false,
    ]
  ];
  protected $dataTableRelationships = [
    "belongsTo" => [
      'account_type' => [
        "model" => \App\Settings\AccountType::class,
        'foreign_key' => 'account_type_id',
        'columns' => [
          'name' => [
            'searchable' => true,
            'orderable' => true,
          ],
        ],
      ],
      'money_format' => [
        "model" => \App\Settings\MoneyFormat::class,
        'foreign_key' => 'money_format_id',
        'columns' => [
          'name' => [
            'searchable' => true,
            'orderable' => true,
          ],
        ],
      ],
    ],
    "belongsToMany" => [
      "users" => [
        "model" => \App\User::class,
        "foreign_key" => "account_id",
        "pivot" => [
          "table_name" => "user_account",
          "primary_key" => "id",
          "foreign_key" => "user_id",
          "local_key" => "account_id",
        ],
        "order_by" => "name",
        "columns" => [
          "name" => [
            "searchable" => true,
            "orderable" => true,
          ]
        ],
      ],
    ]
  ];

    public function getCurrentStatusAttribute()
    {
      return $this->status == 1 ? 'Active' : 'Not Active';
    }

    public function getProfileUrlAttribute()
    {
        return route('accounts.profile', $this->slug);
    }
    public function getLogoMediumAttribute()
    {
        return "/storage/accounts/thumbnail/medium/$this->logo";
    }
    public function getLogoSmallAttribute()
    {
        return "/storage/accounts/thumbnail/small/$this->logo";
    }
    public function getLogoOriginalAttribute()
    {
        return "/storage/accounts/thumbnail/$this->logo";
    }

//    protected $appends = [
//        'current_status',
//        'last_updated',
//        'profile_url',
//        'logo_small',
//        'logo_medium',
//        'logo_original',
//    ];

    public function scopeJoinAccount($query)
    {
        $accountType = AccountType::where('name', 'Join')->first();
        return $query->where('account_type_id', $accountType->id);
    }

    public  function account_type() {
        return $this->belongsTo("App\Settings\AccountType");
    }

    public  function money_format() {
        return $this->belongsTo("App\Settings\MoneyFormat");
    }

    public  function users() {
        return $this->belongsToMany("App\User", "user_account")->withTimestamps();
    }

    public  function transactions() {
        return $this->hasMany("App\Transaction");
    }
}
