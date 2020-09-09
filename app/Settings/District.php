<?php

namespace App\Settings;

use App\MyModel;

class District extends MyModel
{
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'name', 'division_id', 'status'
  ];

  /**
   * @return
   */
  public function division()
  {
    return $this->belongsTo('App\Settings\Division');
  }
  public function upazillas()
  {
    return $this->hasMany('App\Settings\Upazilla');
  }
}
