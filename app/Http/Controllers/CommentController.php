<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\token;
use App\comment;
use App\post;
use App\Http\Resources\CommentsResource;
class CommentController extends Controller
{
    public function comments_post($id)
    {

        $comments = comment::where('post_id' ,$id)->get();
        $post = post::where('id' ,$id)->where('revoke',0)->get();
        if($comments->all() == null || $post->all() == null){
           return response([
               'message' => 'your page not found'
           ],404);
        }else{
            return CommentsResource::collection($comments);
        }

    }

    // get comments post
    public function create(Request $request , $id){
        $post = post::where('id' ,$id)->where('revoke',0)->get();
        if($post->all() == null){
           return response([
               'message' => 'your page not found'
           ],400);
        }else{
            $token = $request->header("Authorization");
            $token_sha = hash('sha1',$token);
            $token = token::where('token',$token_sha)->first();
            $user_id = $token->user_id;
            $body = request('body');
            $title = request('title');
            comment::create(['user_id' => $user_id,'post_id' => $id,'body' => $body, 'title' =>  $title]);
            return response([
                'message' => 'your comment sended'
            ],200);
        }
    }
    //create comment post
}
