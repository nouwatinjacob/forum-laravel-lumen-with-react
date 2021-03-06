<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
  protected $fillable = [
    'title', 'category_id', 'description', 'user_id' 
  ];

  public function category()
  {
    return $this->belongsTo('App\Category');
  }

  public function replies()
  {
    return $this->hasMany('App\Reply');
  }

  public function topicLikes()
    {
        return $this->hasMany('App\TopicLike');
    }
}