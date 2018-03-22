<?php

namespace App\Http\Controllers;

use App\Topic;
use Illuminate\Http\Request;

class TopicsController extends Controller
{
  public function getAllTopics()
  {
    $topics = Topic::orderBy('created_at', 'desc')->paginate(5);
    $categories = Category::all();

    return response()->json($topics, $categories);
  }
}