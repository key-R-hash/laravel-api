<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\post;
use App\User;
use App\comment;
use App\token;
use Auth;
use App\Http\Resources\PostsResource;

class PostController extends Controller
{
    private $id;
    public function create(Request $request){
        $token = $request->header("Authorization");
        $token_sha = hash('sha1',$token);
        $token = token::where('token',$token_sha)->first();
        $user_id = $token->user_id;
        $body = request('body');
        $title = request('title');
        post::create(['user_id' => $user_id,'body' => $body, 'title' =>  $title,'revoke' => 0]);
        return response([
            'message' => 'your post already created'
        ],200);
    }

    public function posts()
    {

        $posts = post::where('revoke',0)->paginate(1);
        return PostsResource::collection($posts);
    }
    // get all posts
    public function post($id)
    {
         $post = post::where('id',$id)->where('revoke',0)->get();
            if($post->all() == null){
                return response([
                    'message' => 'your page not found'
                ],400);
            }else{
                return PostsResource::collection($post);
        }
    }
    // get post

    public function delete(Request $request , $id)
    {
        $token = $request->header("Authorization");
        $token_sha = hash('sha1',$token);
        $token = token::where('token',$token_sha)->first();
        $user_id = $token->user_id;
        $check = post::where('user_id',$user_id)->where('id' ,$id)->get();
        if($check->all() == null){
            return response([
                'message' => 'you dont have access to this post'
            ],403);
        }else{
            post::where('user_id',$user_id)->where('id' ,$id)->update(['revoke' => 1]);
            return response([
                'message' => 'your post deleted'
            ],200);
        }

    }
    public function update(Request $request , $id){
        $token = $request->header("Authorization");
        $token_sha = hash('sha1',$token);
        $token = token::where('token',$token_sha)->first();
        $user_id = $token->user_id;
        $check = post::where('user_id',$user_id)->where('id' ,$id)->get();
        if($check->all() == null){
            return response([
                'message' => 'you dont have access to this post'
            ],403);
        }else{
        $body_update = request('body');
        $title_update = request('title');
        post::where('user_id',$user_id)->where('id' ,$id)->update(['body' => $body_update,'title' => $title_update]);
            return response([
                'message' => 'your post updated'
            ],200);
        }
    }
}
