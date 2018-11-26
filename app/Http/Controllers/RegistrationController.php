<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\post;
use App\User;
use App\comment;
use App\token;
use Auth;

class RegistrationController extends Controller
{

    public function Registration(){
       $this->validate(request(),[
          'name' => 'required',
          'email' => 'required|email',
          'password' => 'required'
       ]);
        $password = bcrypt(request('password'));
		$email = request('email');
		$name = request('name');
        $login = User::create(['email' => $email,'name' => $name, 'password' => $password]);
        if($login){
            return response([
                'message' => 'now you can login'
            ],200);
        }else{
            return response([
                'message' => 'oops try again'
            ],500);
        }
        //auth()->login($login);
    }
}
