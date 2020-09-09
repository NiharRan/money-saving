<?php

namespace App\Settings;

use App\MyModel;

class MoneyFormat extends MyModel
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
  public function accounts()
  {
    return $this->hasMany('App\Account');
  }
}
