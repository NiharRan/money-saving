<?php


namespace App;


use Illuminate\Database\Eloquent\Model;

class MyModel extends Model
{
  public function getLastUpdatedAttribute()
  {
    return $this->updated_at->diffForHumans();
  }

  public function getDefaultDateTimeAttribute()
  {
    return date('d-m-Y h:i A', strtotime($this->updated_at));
  }

  public function getDefaultDateAttribute()
  {
    return date('d-m-Y', strtotime($this->updated_at));
  }

  protected $appends = ['last_updated', 'default_date_time', 'default_date'];

  public static function scopeActive($query)
  {
    return $query->where('status', 1);
  }
}
