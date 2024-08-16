<?php

namespace App\Http\Controllers;


use App\User;
use App\Profile;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Gate;
use Intervention\Image\ImageManagerStatic as Image;

class ProfilesController extends Controller
{
    public function index(User $user, Request $request)
    {
        // 03:49:08' de kaldın. Laravel Telescope gösterecek...
        // kullandığım laravel versiyonunda laravel telescope YOK. Bu yüzden geçtim bu kısmı. Çok kapsamlı Debug aracıymış. Admin paneli gibi...
        $is_user_logged_in = $request->user();

        $user_own_page = false; 

        if (auth()->user()){
            $follows = (auth()->user()->following->contains($user->id));

        }
        else{
            $follows = false;
        }


        if (auth()->user()){
            if (auth()->user()->id == $user->id){
                $user_own_page = true; 
            }
            else{
                $user_own_page = false; 
                
            }
        }
        else{
        }


        // Cache; database'i daha az kullanıp uygulamayı ağırlaştırmıyor. aşağıdaki bilgileri sadece 30
        // saniyede bir yeniliyor. Böylece sayfanın yüklenmesi daha hızlı oluyor ve uygulamaya yük
        // binmiyor. Saniye yerine dakika, saat, gün, ay ve yıl vs vs de verilebiliyor.


        $postCount = Cache::remember(
            'count.post.'. $user->id, 
            \Carbon\Carbon::now()->addSeconds(30), 
            function() use ($user){
                return $user->posts->count();
            }
        );
        

        $followersCount = Cache::remember(
            'count.followers.'. $user->id, 
            \Carbon\Carbon::now()->addSeconds(30), 
            function() use ($user){
                return $user->profile->followers->count();
            }
        );
        
        
        $followingCount = Cache::remember(
            'count.following.'. $user->id, 
            \Carbon\Carbon::now()->addSeconds(30), 
            function() use ($user){
                return $user->following->count();
            }
        );
        
        

        return view('profiles.index', compact('user', 'follows', 'user_own_page', 'is_user_logged_in', 'postCount', 'followersCount', 'followingCount')); // bu fonksiyonla,
        //controlde bulunan değişkeni aynı isimle sayfaya gönderiyoruz... 
    }

   

    use AuthorizesRequests;
    public function edit(User $user)
    {
        Gate::define('update', 'App\Policies\ProfilePolicy@update');

        if (Gate::allows('update', $user->profile)) {
            // Kullanıcı, gönderiyi güncellemeye yetkilendirilmişse, işlem devam eder
            return view('profiles.edit', compact('user'));
        } else {
            // Kullanıcı, gönderiyi güncelleme yetkisine sahip değilse, hata mesajı gösterilir
            abort(403, 'Bu işlemi yapmaya yetkiniz yok.');
        }

        
    }

    public function update(Request $request, User $user)
    {
        Gate::define('update', 'App\Policies\ProfilePolicy@update');

        if (Gate::allows('update', $user->profile)) {
            // Kullanıcı, gönderiyi güncellemeye yetkilendirilmişse, işlem devam eder

            $validator = Validator::make($request->all(), [
                'title' => 'required',
                'description' => 'required',
                'url' => '',
                'image' => 'nullable|image',
            ]);

            

            if($validator->fails()){
                dd("hata var");
            }
            else{
                $validatedData = $validator->getData();
                $title = $validatedData["title"];
                $description = $validatedData["description"];
                $url = $validatedData["url"];
                
                if(request('image')){
                    $image = $validatedData["image"];
                    $imagePath = $image->store('profile', 'public');

                    $resizedImage = Image::make(public_path("storage/{$imagePath}"))->fit(1000,1000);
                    $resizedImage->save();
                    
                    auth()->user()->profile()->update([
                        'title' => $title,
                        'description' => $description,
                        'url' => $url,
                        'image' => $imagePath,
    
                    ]);
                }
                else{
                    auth()->user()->profile()->update([
                        'title' => $title,
                        'description' => $description,
                        'url' => $url,
                        'image' => $user->profile->image,
    
                    ]);
                }

                


                
                return redirect("/profile/" . auth()->user()->id);
            } 

        }
        else {
            // Kullanıcı, gönderiyi güncelleme yetkisine sahip değilse, hata mesajı gösterilir
            abort(403, 'Bu işlemi yapmaya yetkiniz yok.');
        }
    }
}
