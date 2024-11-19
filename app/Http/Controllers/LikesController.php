<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Illuminate\Http\Request;

class LikesController extends Controller
{
    //

    public function checkHasLiked($postId)
    {
        $exists = Like::where('liker_id',auth()->user()->id)->where(['blog_post_id'=>$postId,'is_liked'=>true])->exists();
        return response()->json(['liked' => $exists],200);
    }

    public function likePost(Request $request,$blogPostId){
        Like::updateOrCreate([
            'liker_id' => auth()->user()->id,
            'blog_post_id' => $blogPostId,
        ],[
            'is_liked' => $request->isLiked
        ]);

        return response()->json(['message' => 'Liked Successfully'],200);
    }

    public function getLikes($postId)
    {
        $likes = Like::where('blog_post_id',$postId)->where(['is_liked'=>true])->get();
        return response()->json(['likes' => $likes],200);
    }
}
