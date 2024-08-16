<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\ImageManagerStatic as Image;



class PostsController extends Controller
{
    public function __construct(){
        //construct metodu sayesinde bu controllerdaki bütün fonksiyonlar
        //authorization gerektiriyor.
        $this->middleware('auth');
    }
    
    
    public function index(){
        $users = auth()->user()->following()->pluck('profiles.user_id');
        // pluck fonksiyonu veritabanı tablosundan belirtilen kolonu almamızı sağlar...

        $posts = Post::whereIn('user_id', $users)->with('user')->latest()->paginate(5);
        // with fonksiyonu ile çağıracağımız 'user' ilişkisi her postta tekrar tekrar çağırılmayacak. tek bir seferde çağırılacak
        // böylece uygulama daha hızlı olacak...
        // paginate fonksiyonu da pagination'a yarıyor.
        // ->orderBy('created_at','DESC') ile latest() aynı işe yarıyor. ikiis de kullanılabilir. 

        return view('posts.index', compact('posts'));
    }


    public function create(){
        return view('posts.create');
    }

    public function store(Request $request){

                
        $validator = Validator::make($request->all(), [
            'caption' => 'required',
            'image' => 'required|image',
        ]);

        
        
        if($validator->fails()){
            dd("hata var");
        }
        else{
            $validatedData = $validator->getData();
            $caption = $validatedData["caption"];
            $image = $validatedData["image"];

            $imagePath = $image->store('uploads', 'public');

            $resizedImage = Image::make(public_path("storage/{$imagePath}"))->fit(1200,1200);
            $resizedImage->save();


            auth()->user()->posts()->create([
                'caption' => $caption,
                'image' => $imagePath
            ]);
            
            return redirect("/profile/" . auth()->user()->id);
        }


    }

    public function show(\App\Post $post){
        return view('posts.show', compact('post'));

    }

}
