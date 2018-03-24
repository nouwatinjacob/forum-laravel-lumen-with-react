<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Topic;
use App\Category;
use App\Reply;
use Auth;

class TopicsController extends Controller
{
  public function __construct()
  {
    // $this->middleware('auth', ['only' => 'create']);
  }


  public function getAllTopics()
  {
    $topics = Topic::orderBy('created_at', 'desc')->paginate(5);
       
    return response()->json([
      'status' => 'success', 
      'data' => $topics,
    ], 200);
  }

  public function create(Request $request)
  {
    $this->validate($request,[
      'title' => 'required',
      'category_id' => 'required',
      'description' => 'required'
    ]);
          
    $topic = Topic::create([
      'user_id' => Auth::id(),
      'title' => $request->title,
      'category_id' => $request->category_id,
      'description' => $request->description            
  ]);

    return response()->json([
      'status' => 'success', 
      'message' => 'You stated new Topic successfully',
      'data' => $topic
    ], 201);
  }
  
  public function show($id)
  {    
    $topic = Topic::where('id', $id)->first();    
    $replies = Reply::where('topic_id', $id)->get();

    if(!$topic){
      return response()->json(['status' => 'error', 'message' => 'Topic not found'], 404);
    }
    return response()->json([
      'status' => 'success', 
      'data' => $topic,      
      'replies' => $replies
    ], 200);
  }

  public function topicsOfACategory($id)
  {
    $topic = Topic::where('category_id', $id)->paginate(5);
    $category = Category::find($id);

    if($topic->count() > 0 && $category) {
      return response()->json(['status' => 'success', 'category' => $category, 'data' => $topic], 200);
    }
    else if(!$category){
      return response()->json(['status' => 'error', 'message' => 'Category not found'], 404);
    }
    else {
      return response()->json(['status' => 'error', 'message' => 'This Category has no Topic'], 404);
    }
  } 
}