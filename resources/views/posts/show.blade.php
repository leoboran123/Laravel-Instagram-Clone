@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-4" style="float:right; min-width: 300px;">
                <div><img src="{{$post->user->profile->profile_image()}}" alt="" style="height: 100px; border: 2px solid #eee; border-radius: 100px;"  class="rounded-circle"></div>
                <div><h3 style="font-weight: bolder;"><a href="/profile/{{$post->user->profile->user_id}}">{{$post->user->username}}</a></h3></div>
                <a href="" class="btn btn-primary">Follow</a>
                <hr>
                <h3><span style="font-weight: bolder;"><a href="/profile/{{$post->user->profile->user_id}}">{{$post->user->username}}</a></span>: {{ $post->caption }}</h3>
        </div>
        <div class="col-7" style="float:left;">
            <img src="/storage/{{ $post->image }}" alt="" class="w-100" style="height: 500px; align-items:center;">

        </div>
    </div>

</div>
@endsection
