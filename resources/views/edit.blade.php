@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Created</div>

                <div class="panel-body">
                    <form class="form-horizontal" enctype="multipart/form-data" method="POST" action="{{ url("room/{$room->id}/update") }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                            <label for="title" class="col-md-4 control-label">名称</label>

                            <div class="col-md-6">
                                <input id="title" type="text" class="form-control" name="title" value="{{ old('title') ?? $room->title }}" required autofocus>

                                @if ($errors->has('title'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('cover') ? ' has-error' : '' }}">
                            <label for="cover" class="col-md-4 control-label">空间封面</label>

                            <div class="col-md-6">
                                <input type="file" id="cover" name="cover" value="{{ old('cover') }}">

                                @if ($errors->has('cover'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('cover') }}</strong>
                                    </span>
                                @endif

                                @if($room->title)
                                    <img src="{{asset(empty($room->cover) ? config('room.default_room_pic') : config('room.file_type') . $room->cover)}}"
                                         alt="">
                                @endif
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('isPrivate') ? ' has-error' : '' }}">
                            <label for="isPrivate" class="col-md-4 control-label">是否私密</label>

                            <div class="col-md-6">
                                <label class="radio-inline">
                                    <input type="radio" class="isPrivate" name="isPrivate" value="0" {{$room->is_private == 0 ? "checked" : ""}}> 否
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" class="isPrivate" name="isPrivate" value="1" {{$room->is_private == 1 ? "checked" : ""}} > 是
                                </label>

                                @if ($errors->has('isPrivate'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('isPrivate') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group {{$room->is_private == 1 ? 'show' : 'hidden'}} {{ $errors->has('cipher') ? ' has-error' : '' }}" id="cipherDiv">
                            <label for="cipher" class="col-md-4 control-label">密码</label>

                            <div class="col-md-6">
                                <input id="cipher" type="password" class="form-control" name="cipher" autofocus>

                                @if ($errors->has('cipher'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('cipher') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Created
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('js/add.js') }}"></script>
@endsection

<style>
    img {
        height: 150px;
    }
</style>
