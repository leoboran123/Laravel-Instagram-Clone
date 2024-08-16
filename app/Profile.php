<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $guarded = [];

    public function profile_image(){
        $imagePath = "/storage/";

        if($this->image){
            $imagePath = $imagePath.$this->image;
        }
        else{
            $imagePath = $imagePath."profile/fdz6Dl4IZSzaN7PhWsx3jZWh5aYaXhd8XJPGyqe6.jpeg";
        }

        return $imagePath;
    }
    

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function followers(){
        return $this->belongsToMany(User::class);
    }
}
