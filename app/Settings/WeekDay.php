<?php

namespace App\Settings;

use Illuminate\Database\Eloquent\Model;

class WeekDay extends Model
{
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'name'
  ];
}
