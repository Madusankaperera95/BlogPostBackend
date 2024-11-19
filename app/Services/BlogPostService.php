<?php

namespace App\Services;

use App\DTO\CommentDTO;
use App\Models\BlogPost;
use App\Models\Comment;
use App\Models\User;
use App\Traits\ImagesTrait;
use Illuminate\Support\Collection;

class BlogPostService
{
    use ImagesTrait;
        public function getLatest3Posts(): Collection{
            $latestPosts = BlogPost::with([
                'author' => function ($query) {
                    $query->select('id', 'name');  // Select only author name
                },
                'category' => function ($query) {
                    $query->select('id', 'category');  // Select only category name
                }
            ])->latest()->take(3)->select(['id','title','description','tags','post_image','tags','author_id','category_id','created_at as posted_at'])->get()->map(function ($post){
               // $post['post_image'] = $this->getImageUrl($post['post_image']);
                $post['tags'] = json_decode($post['tags'],true);
                $post['posted_at'] = date("d F Y H:i", strtotime($post['posted_at']));
                return $post;
            });

            return $latestPosts;
       }

       public function getRandomPosts(): Collection{
           $latestPosts = BlogPost::with([
               'author' => function ($query) {
                   $query->select('id', 'name');  // Select only author name
               },
               'category' => function ($query) {
                   $query->select('id', 'category');  // Select only category name
               }
           ])->inRandomOrder()->take(4)->select(['id','title','description','tags','post_image','tags','author_id','slug','category_id','created_at as posted_at'])->get()->map(function ($post){
               //$post['post_image'] = $this->getImageUrl($post['post_image']);
               $post['tags'] = json_decode($post['tags'],true);
               $post['posted_at'] = date("d F Y H:i", strtotime($post['posted_at']));
               return $post;
           });

           return $latestPosts;
       }

       public function getPostDetails(int $id):BlogPost|null{
           $post = BlogPost::where('id',$id)->with(['author' => function ($query) {
               $query->select('id', 'name');  // Select only author name
           },
               'category' => function ($query) {
                   $query->select('id', 'category');  // Select only category name
               }
           ])->with([ 'author' => function ($query) {
               $query->select('id', 'name');  // Select only author name
           },
               'category' => function ($query) {
                   $query->select('id', 'category');  // Select only category name
               }])->select(['id','title','description','tags','post_image','tags','author_id','slug','category_id','created_at as posted_at'])->first();

           if($post) {
               //$post['post_image'] = $this->getImageUrl($post['post_image']);
               $post['tags'] = json_decode($post['tags'], true);
               $post['posted_at'] = date("d F Y H:i", strtotime($post['posted_at']));
           }

           return $post;
       }

       public function addComment(CommentDTO $commentDTO,User $user)
       {
           $post = $this->getPostDetails($commentDTO->postId);
           $post->comments()->create(['commentor_id'=> $user->id,'comment'=>$commentDTO->comment]);
       }

       public function getPostComments(int $postId): Collection
       {
           $postComments = Comment::where('blog_post_id',$postId)->with(['commentor' => function($query){
               $query->select('id', 'name','picture');
           }])->orderBY('created_at','desc')->get();
           return $postComments;
       }

    public function postsByAuthor(int $authorId): Collection
    {
        $postComments = BlogPost::where('author_id',$authorId)->with(['category','author'])->get()->map(function ($post){
//            $post['post_image'] = $this->getImageUrl($post['post_image']);
            $post['tags'] = json_decode($post['tags'],true);
            $post['posted_at'] = date("d F Y", strtotime($post['created_at']));
            return $post;
        });
        return $postComments;
    }

    public function getCategoryPosts($categoryId): Collection{
        $posts = BlogPost::where('category_id',$categoryId)->with(['category','author'])->get()->map(function ($post){
           // $post['post_image'] = $this->getImageUrl($post['post_image']);
            $post['tags'] = json_decode($post['tags'],true);
            $post['posted_at'] = date("d F Y", strtotime($post['created_at']));
            return $post;
        });
        return $posts;
    }

    public function getPopularPosts() : Collection{
        return BlogPost::withCount(['likes'])->with('category')->orderBy('likes_count','desc')->take(4)->get()->select(['id','title','post_image','slug','created_at','category'])->map(function ($post){
//            $post['post_image'] = $this->getImageUrl($post['post_image']);
            $post['posted_at'] = date("d F Y", strtotime($post['created_at']));
            return $post;
        });
    }

    public function SearchByTag($tag){
           return BlogPost::whereJsonContains('tags',$tag)->with(['category','author'])->get()->map(function ($post){
               $post['post_image'] = $this->getImageUrl($post['post_image']);
               $post['tags'] = json_decode($post['tags'],true);
               $post['posted_at'] = date("d F Y", strtotime($post['created_at']));
               return $post;
           });
    }
}
