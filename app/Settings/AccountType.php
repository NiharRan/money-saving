<?php

namespace App\Settings;

use App\MyModel;

class AccountType extends MyModel
{
    /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'name', 'slug', 'status'
  ];

  public function scopeIsJoin($query)
  {
      return $query->where('name', 'Join');
  }

  /**
   * @return
   */
  public function accounts()
  {
    return $this->hasMany('App\Account');
  }
}
