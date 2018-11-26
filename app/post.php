<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\comment;

class post extends Model
{
    protected $fillable = array('user_id','body','title','revoke');

    public function comment(){
        return $this->hasMany(comment::class);
    }
    public function User(){
        return $this->belongsTo(User::class);
    }
}
