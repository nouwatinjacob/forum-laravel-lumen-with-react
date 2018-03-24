<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Reply;
use App\Category;
use App\Topic;
use App\ReplyLike;
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


    public function like($id)
    {
        $liked = ReplyLike::where('user_id', Auth::id())->where('reply_id', $id)->where('like', 1)->first();
        $unliked = ReplyLike::where('user_id', Auth::id())->where('reply_id', $id)->where('like', 0)->first();

        if($liked){
          return response()->json(['message' => 'You currently liked this Reply'], 200);
        }

        elseif($unliked)
        {
            $unliked->delete();
            ReplyLike::create([
                'user_id' => Auth::id(),
                'reply_id' => $id,
                'like' => 1
            ]);

            return response()->json(['status' => 'success', 'message' => 'You now liked this Reply'], 201);
        }

        else{
             ReplyLike::create([
                'user_id' => Auth::id(),
                'reply_id' => $id,
                'like' => 1
            ]);

            return response()->json(['status' => 'success', 'message' => 'You now liked this Reply'], 201);
        }
    }


    public function unlike($id)
    {
        $liked = ReplyLike::where('user_id', Auth::id())->where('reply_id', $id)->where('like', 1)->first();
        $unliked = ReplyLike::where('user_id', Auth::id())->where('reply_id', $id)->where('like', 0)->first();

        if($liked){
            $liked->delete();

            ReplyLike::create([
                'user_id' => Auth::id(),
                'reply_id' => $id,
                'like' => 0
            ]);
            
            return response()->json(['status' => 'success', 'message' => 'You now unliked this Reply'], 201);
        }
        elseif($unliked){
            
            return response()->json(['message' => 'You currently unliked this Reply'], 200);
        }
        else{
            ReplyLike::create([
                'user_id' => Auth::id(),
                'reply_id' => $id,
                'like' => 0
            ]);
            
            return response()->json(['status' => 'success', 'message' => 'You now unliked this Reply'], 201);
        }        
        
    }

}