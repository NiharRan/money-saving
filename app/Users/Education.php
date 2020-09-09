<?php

namespace App\Users;

use App\MyModel;

class Education extends MyModel
{
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'user_id', 'degree_id', 'group_id', 'board_id', 'institute',
    'result', 'passing_year', 'roll_no', 'registration_no', 'status',
  ];

  public function user()
  {
    return $this->belongsTo('App\User');
  }

  public function group()
  {
    return $this->belongsTo('App\Educations\Group');
  }

  public function degree()
  {
    return $this->belongsTo('App\Educations\Degree');
  }

  public function board()
  {
    return $this->belongsTo('App\Educations\Board');
  }
}
