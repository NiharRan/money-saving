<?php

namespace App\Users;

use App\MyModel;

class Religion extends MyModel
{
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'name', 'status'
  ];

  public function users()
  {
    return $this->hasMany('App\User');
  }
}
