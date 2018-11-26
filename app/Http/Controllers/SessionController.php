<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\post;
use App\User;
use App\comment;
use App\token;
use Auth;

class SessionController extends Controller
{
    private $id;
    private $token = "";
    public function token(){
        $i = 0;
        $characters = "qwertyuiopasdfghjklzxcvbnm147258369";
        $characters_count = strlen($characters);

        while($i <= 6){
            $rand = mt_rand(0,33);
            $this->token = $this->token . substr($characters,$rand,1);
            $i++;
        }
        return $this->token;
    }
    public function logout(Request $request){
        $token = $request->header("Authorization");
        $token_sha = hash('sha1',$token);
        token::where('token',$token_sha)->update(['revoke' => '1']);
        auth()->logout();
        return response([
            'message' => 'logout successful'
        ],200);
    }
    public function login(){
        if(auth()->attempt(request(["email","password"]))){
            $email = request('email');
            $user = Auth::user();
            $this->id = (string)$user->id;
            $tokenPlaneText = (string)$this->token();
            $this->token = hash('sha1', $tokenPlaneText);
            $revoke = 0;
            $create = token::create(['user_id' => $this->id,'token' => $this->token ,'revoke' => $revoke]);
            $token_id = $create->id;
            $user_token = User::where('email',$email)->update(["token_id" => $token_id]);
            return response([
                'token' => $tokenPlaneText
            ],200);
        } else{
            return response([
                'message' => 'Unauthorized'
            ], 401);
        }


    }
}
