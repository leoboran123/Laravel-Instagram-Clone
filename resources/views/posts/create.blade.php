@extends('layouts.app')

@section('content')

<div class="container">

    <form action="/p" enctype="multipart/form-data" method="POST">
        {{ csrf_field() }}

        <div class="row">
            <div class="col-8 offset-2">

                <div class="row">
                    <h1>Add New Post</h1>
                </div>

                <div class="row">
                    <div class="form-group{{ $errors->has('caption') ? ' has-error' : '' }}">
                        <label for="caption" class="">Caption</label>
                        <input id="caption" name="caption" type="text" class="form-control" caption="caption" value="{{ old('caption') }}" autofocus>

                        @if ($errors->has('caption'))
                            <span class="help-block">
                                <strong>{{ $errors->first('caption') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <label for="image" class="">Image</label>
                    <input type="file" class="" id="image" name="image">
                    @if ($errors->has('image'))
                        <span class="help-block">
                            <strong>{{ $errors->first('image') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="row">
                    <button type="submit" class="btn btn-primary" style="margin-top: 10px;">Post</button>
                </div>

            </div>

        </div>
    </form>
</div>

@endsection
