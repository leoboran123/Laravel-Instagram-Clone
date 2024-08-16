@extends('layouts.app')

@section('content')
<div class="container">
    @foreach ($posts as $post)
        <hr style="border: 5px solid grey;">
        <div class="row" style="margin: auto">
        
            <div class="col-7">
                <a href="/p/{{$post->id}}">
                    <img src="/storage/{{ $post->image }}" alt="" class="w-100" style="height: 500px; align-items:center;">
                </a>
            </div>
            <div class="col-4" >
                <hr>
                <h3><span style="font-weight: bolder;"><a href="/profile/{{$post->user->profile->user_id}}">{{$post->user->username}}</a></span>: {{ $post->caption }}</h3>
            </div>
        </div>
        @endforeach

        <div class="row">
            <div class="col-12 d-flex" style="margin-left: 50%">
                {{ $posts->links() }}
                <!-- kullandığımız pagination'u göstermeye yarıyor -->
            </div>
        </div>
</div>
@endsection
