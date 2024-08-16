@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-3 p-5" style="float: left;">
            <img src="{{$user->profile->profile_image()}}" style="height: 200px; border: 2px solid #eee; border-radius: 100px;"  class="rounded-circle">
        </div>
        <div class="col-9" style="float: left; margin-left: 20px;">
            <div>
                <h1>{{ $user->username }}</h1>
                @if ($user_own_page)

                @else
                    @if (!$is_user_logged_in)
                        <button id="followButton"><a href="/login">Follow</a></button>
                    @else
                        @if ($follows==true)
                            <button onclick="followUser()" id="followButton">Unfollow</button>
                        @else
                            <button onclick="followUser()" id="followButton">Follow</button>
                        @endif
                    @endif
                @endif
            </div>
            @can('update', $user->profile)
                <a href="/p/create" class="newPostButton">Add New Post</a>
                <a href="/profile/{{$user->id}}/edit" class="newPostButton">Edit Profile</a>
            @endcan
            <div class="d-flex flex-row">
                <div class="pt-2"><strong>{{$postCount}}</strong> posts</div>
                <div class="pt-2"><strong>{{$followersCount}}</strong> followers</div>
                <div class="pt-2"><strong>{{$followingCount}}</strong> following</div>
            </div>
            <div style="font-weight: bold; margin-top: 4px;">{{ $user->profile->title }}</div>
            <div>{{ $user->profile->description }}</div>
            <div><a href="">{{ $user->profile->url }}</a></div>
        </div>

    </div>
    <div class="row" style="margin-top: 20px;">
        @foreach($user->posts as $post)
        <div class="col-4">
            <a href="/p/{{ $post->id }}">
                <!-- 2.25.21'de kaldın... Resme tıklandığında büyütmeyi yapıyon... -->
                <img src="/storage/{{ $post->image }}" style="height: 280px; float:left; padding-left: 10px; margin-top: 5px;" alt="">
            </a>
        </div>
        @endforeach
    </div>

</div>

<script>
    function followUser(){

        document.getElementById("followButton").innerHTML = "";
        // document.getElementById("dislikeButton"+post_id).innerHTML = "";
        
        
        
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {  
                
                document.getElementById("followButton").innerText = this.responseText;                    
                // alert(this.responseText)
            };
            
            
        }
        xmlhttp.open("GET","/follow/{{$user->id}}.php",true);
        xmlhttp.send();
    }
    </script>
@endsection
