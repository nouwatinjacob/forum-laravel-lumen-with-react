<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
  protected $fillable = [
    'content', 'topic_id', 'user_id' 
  ];

  public function topic()
  {
    return $this->belongsTo('App\Topic');
  }

  public function user()
  {
    return $this->belongsTo('App\User');
  }
}