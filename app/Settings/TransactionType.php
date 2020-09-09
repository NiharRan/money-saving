<?php

namespace App\Settings;

use App\MyModel;

class TransactionType extends MyModel
{
    /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'name', 'slug', 'status'
  ];

  /**
   * @return
   */
  public function transactions()
  {
    return $this->hasMany('App\Transaction');
  }
}
