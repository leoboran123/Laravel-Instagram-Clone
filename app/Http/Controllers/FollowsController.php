<?php

namespace App\Http\Controllers;


use App\User;

use Illuminate\Http\Request;

class FollowsController extends Controller
{
    // adam normalde bu işlemler için index blade'de vue.js kullanıyor fakat bende çalışmadığı için ben ajax kullandım...
    // iki model arasında many to many rel. kurmak için yeni bir model oluşturmaya GEREK YOK!

    // php artisan make:migration creates_profile_user_pivot_table (migration ismi) --create profile_user 
    // (burada iki modelin isimleri küçük şekilde alfabetik olarak sıralanıp aralarına _ konması gerekiyor) 

    // YANİ

    // php artisan make:migration cerates_profile_user_pivot_table --create profile_user


    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function store(User $user){
        
        // bağlı veya bağlı olmayan şeyleri bağlar. biz burada bağlıları bağlıyoruz
        auth()->user()->following()->toggle($user->profile);
        


        if(auth()->user()->following->contains($user->id)){
            return "Unfollow";
        }
        else if(!(auth()->user()->following->contains($user->id))){
            return "Follow";
        }
        else{
            return "window.location.href = '/login';";
        }
        
        

    }
}
