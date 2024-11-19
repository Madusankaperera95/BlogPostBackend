<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/register',[\App\Http\Controllers\RegisterController::class,'register']);
Route::post('/login',[\App\Http\Controllers\RegisterController::class,'login']);
Route::post('/changePassword',[\App\Http\Controllers\RegisterController::class,'changePassword'])->middleware('auth:sanctum');
Route::post('/updateUser',[\App\Http\Controllers\RegisterController::class,'updateUser']);
Route::delete('/logout',[\App\Http\Controllers\RegisterController::class,'logout'])->middleware('auth:sanctum');
Route::get('/getLandingPageMainPosts',[\App\Http\Controllers\BlogPostsController::class,'getLatestThreePosts']);
Route::get('/getRandomPosts',[\App\Http\Controllers\BlogPostsController::class,'getRandomPosts']);
Route::get('/getPost/{id}',[\App\Http\Controllers\BlogPostsController::class,'getPost']);
Route::post('/addComment',[\App\Http\Controllers\BlogPostsController::class,'pushComment'])->middleware('auth:sanctum');
Route::get('/post/{postId}/comments',[\App\Http\Controllers\BlogPostsController::class,'postComments']);
Route::get('/popularPosts',[\App\Http\Controllers\BlogPostsController::class,'getPopularPosts']);

Route::get('/author/{authorId}/posts',[\App\Http\Controllers\BlogPostsController::class,'authorPosts']);
Route::get('/category/{categoryId}/posts',[\App\Http\Controllers\BlogPostsController::class,'categoryPosts']);
Route::get('/categories',\App\Http\Controllers\CategoryController::class);
Route::get('/postsByTag',[\App\Http\Controllers\BlogPostsController::class,'searchByTag']);
Route::post('/subscribe',[\App\Http\Controllers\SubscribeController::class,'subscribe'])->middleware('auth:sanctum');
Route::get('/hasSubscribed/{authorId}',[\App\Http\Controllers\SubscribeController::class,'checkSubscribed'])->middleware('auth:sanctum');
Route::post('/blogPosts/{blogPostId}/incrementView',[\App\Http\Controllers\SubscribeController::class,'increaseViewCount']);
Route::post('/likeThePost/{blogPostId}',[\App\Http\Controllers\LikesController::class,'likePost'])->middleware('auth:sanctum');


Route::get('/hasLiked/{postId}',[\App\Http\Controllers\LikesController::class,'checkHasLiked'])->middleware('auth:sanctum');
Route::get('/post/{postId}/likes',[\App\Http\Controllers\LikesController::class,'getLikes']);






//Route::post('/uploadData',function (Request $request){
//
//          $picture = $request->file('post_image');
//          $pictureName = time().'.'.$picture->getClientOriginalExtension();
//          $path = Storage::disk('s3')->putFileAs('uploads',$picture,$pictureName);
//
//          \App\Models\BlogPost::create([
//              'title' =>  $request->title,
//              'description' => $request->description,
//              'author_id' => $request->author_id,
//              'category_id' => $request->category_id,
//              'tags' => $request->tags,
//              'post_image' => $path,
//              'slug' => $request->slug
//          ]);
//
//          return response()->json('Interted Succsesfully',200);
//
//});

