<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\Subscriber;
use Illuminate\Http\Request;

class SubscribeController extends Controller
{
    public function subscribe(Request $request)
    {
        $request->validate([
            'author_id' => 'required|exists:users,id',
            'is_subscribed' => 'required|boolean'
        ]);

        Subscriber::updateOrCreate([
                'author_id' => $request->author_id,
                'commentor_id' => $request->user()->id
            ],
            [
                'is_subscribed' => $request->is_subscribed
           ]);

        return response()->json(['message'=>'Subscribed Successfully'],200);
    }

    public function checkSubscribed($authorId)
    {
        try {
            $status = Subscriber::where('author_id',$authorId)->where(['commentor_id'=>auth()->user()->id])->first()->is_subscribed;
            return response()->json(['status'=>$status],200);
        }
        catch(\Exception $e){
            return response()->json(['status'=>false],200);
        }

    }


    public function increaseViewCount($blogPostId)
    {
        BlogPost::where('id',$blogPostId)->increment('views_count');
        return response()->json(['message'=>'Successfully Count is increment'],200);
    }
}
