<?php

namespace App\Settings;

use App\MyModel;

class Division extends MyModel
{
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'name', 'status'
  ];
  /**
   * @var mixed
   */

  public function districts()
  {
    return $this->hasMany('App\Settings\District');
  }
  public function upazillas()
  {
    return $this->hasMany('App\Settings\Upazilla');
  }
}
