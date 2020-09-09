<?php

namespace App\Settings;

use App\MyModel;

class Upazilla extends MyModel
{
    protected $table = 'upazillas';
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'name', 'district_id', 'division_id', 'status'
  ];
  /**
   * @var mixed
   */

  public function district()
  {
    return $this->belongsTo('App\Settings\District');
  }
  public function division()
  {
    return $this->belongsTo('App\Settings\Division');
  }
}
