<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\post;
use App\User;

class comment extends Model
{
    protected $fillable = array('user_id','body','title','post_id');
    public function post(){
        return $this->belongsTo(post::class);
    }
    public function User(){
        return $this->belongsTo(User::class);
    }
}
