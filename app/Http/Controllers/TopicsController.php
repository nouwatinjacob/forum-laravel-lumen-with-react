<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Topic;
use App\Category;
use Auth;

class TopicsController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth', ['only' => 'create']);
  }


  public function getAllTopics()
  {
    $topics = Topic::orderBy('created_at', 'desc')->paginate(5);
    // $categories = Category::all();   
    return response()->json(['status' => 'success', 'topics' => $topics], 200);
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
      'message' => 'Topic successfully created',
      'topic' => $topic
    ], 201);
  }
  
  public function show($id)
  {    
    $topic = Topic::where('id', $id)->first();
    if(!$topic){
      return response()->json(['status' => 'error', 'message' => 'Topic not found'], 404);
    }
    return response()->json(['status' => 'success', 'topic' => $topic], 200);
  }
}