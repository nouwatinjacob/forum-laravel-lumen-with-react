<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Reply;
use App\Category;
use App\Topic;
use Auth;

class RepliesController extends Controller
{
  public function store(Request $request, $id)
    {
      
       $topic = Topic::find($id)->first();

       $reply = Reply::create([
        'user_id' => Auth::id(),
        'topic_id' => $topic->id,
        'content' => $request->content
       ]);

       return response()->json([
        'status' => 'success', 
        'message' => 'Reply posted successfully',
        'data' => $reply
      ], 201); 
    }
}