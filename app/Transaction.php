<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
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
        'status'
    ];

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
