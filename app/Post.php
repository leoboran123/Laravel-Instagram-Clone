<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $guarded = [];

    //02.03.57' dakikada kaldın...

    public function user(){
        return $this->belongsTo(User::class);
    }
}
