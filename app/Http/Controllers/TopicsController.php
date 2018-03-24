<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Topic;
use App\Category;
use App\Reply;
use App\TopicLike;
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
  
  
  public function like($id)
    {   
        $liked = TopicLike::where('user_id', Auth::id())->where('topic_id', $id)->where('like', 1)->first();
        $unliked = TopicLike::where('user_id', Auth::id())->where('topic_id', $id)->where('like', 0)->first();
        if($liked){
            return response()->json(['message' => 'You currently liked this Topic'], 200);
        }

        elseif($unliked)
        {
            $unliked->delete();
            TopicLike::create([
                'user_id' => Auth::id(),
                'topic_id' => $id,
                'like' => 1
            ]);
            
            return response()->json(['status' => 'success', 'message' => 'You now liked this Topic'], 201);
        }

        else{
             TopicLike::create([
                'user_id' => Auth::id(),
                'topic_id' => $id,
                'like' => 1
            ]);
            
            return response()->json(['status' => 'success', 'message' => 'You now liked this Topic'], 201);
        }
        
    }


    public function unlike($id)
    {
        $liked = TopicLike::where('user_id', Auth::id())->where('topic_id', $id)->where('like', 1)->first();
        $unliked = TopicLike::where('user_id', Auth::id())->where('topic_id', $id)->where('like', 0)->first();

        if($liked){
            $liked->delete();

            TopicLike::create([
                'user_id' => Auth::id(),
                'topic_id' => $id,
                'like' => 0
            ]);

            return response()->json(['status' => 'success', 'message' => 'You now unliked this Topic'], 201);
        }
        elseif($unliked){
            
            return response()->json(['message' => 'This Topic is currently unliked by you'], 200);
        }
        else{
            TopicLike::create([
                'user_id' => Auth::id(),
                'topic_id' => $id,
                'like' => 0
            ]);
            
            return response()->json(['status' => 'success', 'message' => 'You now unliked this Topic'], 201);        
          }        
        
    }

}