<?php

namespace App\Users;

use App\MyModel;

class Address extends MyModel
{
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'user_id', 'address', 'upazilla_id', 'district_id', 'division_id', 'postcode', 'type'
  ];

  public function user()
  {
    return $this->belongsTo('App\User');
  }
  public function upazilla()
  {
    return $this->belongsTo('App\Settings\Upazilla');
  }
  public function district()
  {
    return $this->belongsTo('App\Settings\District');
  }
  public function division()
  {
    return $this->belongsTo('App\Settings\Division');
  }
}
