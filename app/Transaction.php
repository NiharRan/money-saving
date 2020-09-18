<?php

namespace App;


use JamesDordoy\LaravelVueDatatable\Traits\LaravelVueDatatableTrait;

class Transaction extends MyModel
{
  use LaravelVueDatatableTrait;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'invoice',
        'account_id',
        'user_id',
        'transaction_type_id',
        'amount',
        'trans_date',
        'received_by',
        'status'
    ];
  protected $dataTableColumns = [
    'id' => [
      'searchable' => false,
    ],
    'invoice' => [
      'searchable' => true,
    ],
    'amount' => [
      'searchable' => true,
    ],
    'trans_date' => [
      'searchable' => true,
    ],
  ];
  protected $dataTableRelationships = [
    "belongsTo" => [
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
      'user' => [
        "model" => \App\User::class,
        'foreign_key' => 'user_id',
        'columns' => [
          'name' => [
            'searchable' => true,
            'orderable' => true,
          ],
        ],
      ],
      'transaction_type' => [
        "model" => \App\Settings\TransactionType::class,
        'foreign_key' => 'transaction_type_id',
        'columns' => [
          'name' => [
            'searchable' => true,
            'orderable' => true,
          ],
        ],
      ],
    ],
  ];


//    protected $appends = [
//      'transaction_date',
//      'default_date_time'
//    ];

    public function getTransactionDateAttribute()
    {
      return date('d/m/Y', strtotime($this->trans_date));
    }
    public function getDefaultDateTimeAttribute()
    {
      return date('d-m-Y h:i A', strtotime($this->updated_at));
    }

    public  function transaction_type() {
        return $this->belongsTo("App\Settings\TransactionType");
    }

    public  function user() {
        return $this->belongsTo("App\User");
    }

  public  function creator() {
    return $this->belongsTo("App\User", 'received_by', 'id')
      ->selectRaw('users.name,avatar,slug');
  }

    public  function account() {
        return $this->belongsTo("App\Account");
    }
}
