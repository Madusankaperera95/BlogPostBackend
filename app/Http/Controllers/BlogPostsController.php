<?php

namespace App\Http\Controllers;

use App\DTO\CommentDTO;
use App\Models\BlogPost;
use App\Models\Comment;
use App\Models\User;
use App\Services\BlogPostService;
use App\Traits\ImagesTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BlogPostsController extends Controller
{
    use ImagesTrait;
    public BlogPostService $blogPostService;

    public function __construct(BlogPostService $blogPostService)
    {
       $this->blogPostService = $blogPostService;
    }

    public function getLatestThreePosts(Request $request){
        $latestPosts = $this->blogPostService->getLatest3Posts();
        return response()->json(['posts' => $latestPosts],200);
    }

    public function getRandomPosts(Request $request){
        $latestPosts = $this->blogPostService->getRandomPosts();
        return response()->json(['posts' => $latestPosts],200);
    }


    public function getPost($id){
        $post = $this->blogPostService->getPostDetails($id);
        return response()->json(['post' => $post],200);

    }

    public function pushComment(Request $request){

        $commentDTO = new CommentDTO(postId: $request->postId,comment:$request->comment );
        $this->blogPostService->addComment($commentDTO,$request->user());
        return response()->json(['message' => 'Successfully comment added'],200);
    }

    public function postComments($postId)
    {
        $comments = $this->blogPostService->getPostComments($postId);
        return response()->json(['comments'=>$comments],200);
    }

    public function authorPosts($authorId){
        $posts = $this->blogPostService->postsByAuthor($authorId);
        return response()->json(['posts' => $posts],200);
    }

    public function categoryPosts($categoryId){
        $posts = $this->blogPostService->getCategoryPosts($categoryId);
        return response()->json(['posts' => $posts],200);
    }

    public function searchByTag(Request $request){
        $tag = $request->input('tag');
        $posts = $this->blogPostService->SearchByTag($tag);
        return response()->json(['posts' => $posts],200);
    }

    public function getPopularPosts(){
        $posts = $this->blogPostService->getPopularPosts();
        return response()->json(['posts'=>$posts],200);
    }

}
