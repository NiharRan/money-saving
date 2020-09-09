<?php


namespace App;


use Illuminate\Database\Eloquent\Model;

class MyModel extends Model
{
  public function getLastUpdatedAttribute()
  {
    return $this->updated_at->diffForHumans();
  }

  protected $appends = ['last_updated'];

  public static function scopeActive($query)
  {
    return $query->where('status', 1);
  }
}
