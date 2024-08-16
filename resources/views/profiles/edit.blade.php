@extends('layouts.app')

@section('content')
<div class="container">
<form action="/profile/{{ $user->id }}" enctype="multipart/form-data" method="POST">
        {{ csrf_field() }}
        {{ method_field('PATCH') }}

        <div class="row">
            <div class="col-8 offset-2">

                <div class="row">
                    <h1>Edit Profile</h1>
                </div>

                <div class="row">
                    <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                        <label for="title" class="">Title</label>
                        <input id="title" value="{{ old('title') ? old('title') : $user->profile->title }}" name="title" type="text" class="form-control" title="title" value="{{ old('title') }}" autofocus>

                        @if ($errors->has('title'))
                            <span class="help-block">
                                <strong>{{ $errors->first('title') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="row">
                    <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                        <label for="description" class="">Description</label>
                        <input id="description" value="{{  old('title') ? old('title') : $user->profile->description }}" name="description" type="text" class="form-control" description="description" value="{{ old('description') }}" autofocus>

                        @if ($errors->has('description'))
                            <span class="help-block">
                                <strong>{{ $errors->first('description') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="form-group{{ $errors->has('url') ? ' has-error' : '' }}">
                        <label for="url" class="">Url</label>
                        <input id="url" name="url" value="{{  old('title') ? old('title') : $user->profile->url }}" type="url" class="form-control" url="url" value="{{ old('url') }}" autofocus>

                        @if ($errors->has('url'))
                            <span class="help-block">
                                <strong>{{ $errors->first('url') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="row">
                    <div class="form-group{{ $errors->has('image') ? ' has-error' : '' }}">
                        <label for="image" class="">Profile Image</label>
                        <input id="image" name="image" type="file" class="form-control-file" url="image" value="{{ old('image') }}" autofocus>

                        @if ($errors->has('image'))
                            <span class="help-block">
                                <strong>{{ $errors->first('image') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                

                <div class="row">
                    <button type="submit" class="btn btn-primary" style="margin-top: 10px;">Update</button>
                </div>

            </div>

        </div>
    </form>
    

</div>
@endsection
