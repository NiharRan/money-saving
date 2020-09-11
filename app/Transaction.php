<?php

namespace App;


class Transaction extends MyModel
{
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
        'status'
    ];

    protected $appends = [
      'transaction_date',
      'default_date_time'
    ];

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

    public  function account() {
        return $this->belongsTo("App\Account");
    }
}
