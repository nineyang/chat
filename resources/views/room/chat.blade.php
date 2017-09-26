@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">

            <div class="col-md-8 col-md-offset-2">

                <div class="row">
                    {{--room start--}}
                    <div class="col-sm-12 col-md-12">
                        <div class="thumbnail">

                            <div class="caption">
                                {{--头部--}}
                                <h4>{{$room->title}}</h4>

                                {{--内容--}}
                                <div class="content">


                                    @foreach($messages as $message)

                                        <div class="{{Auth::user()->id == $message->user_id ? 'chat-right' : 'chat-left'}}">
                                            <img src="/{{config('room.default_avatar')}}" alt=""
                                                 class="avatar pull-{{Auth::user()->id == $message->user_id ? 'right' : 'left'}}">
                                            <div class="{{Auth::user()->id == $message->user_id ? 'pull-right' : 'pull-left'}}">
                                                <span class="username">{{$message->user_name}}</span>
                                                <br>
                                                <span class="content-span">{{$message->content}}</span>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>

                                    @endforeach

                                </div>

                                {{--底部--}}
                                <div class="form-group">
                                    <textarea class="form-control wait-send" rows="3"></textarea>
                                </div>
                                <button class="btn btn-primary pull-right"
                                        role="button" id="send">发送
                                </button>
                                <div class="clearfix"></div>

                            </div>
                        </div>
                    </div>
                    {{--room end--}}
                    <span class="default-value hide" data-default-avatar="{{config('room.default_avatar')}}"
                          data-user-id="{{Auth::user()->id}}" data-room-id="{{$room->id}}"></span>

                </div>

            </div>
        </div>

    </div>

    <script src="{{asset('js/ws.js')}}">

    </script>

@endsection

<style>
    .row .thumbnail img {
        height: 150px;
        cursor: pointer;
    }

    .content {
        background: #ffffff;
        height: 350px;
        margin-bottom: 20px;
        border: 1px solid #ccd0d2;
        border-radius: 4px;
        box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
        transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
        max-height: 350px;
        overflow: scroll;
        padding: 5px;
    }

    .row .thumbnail .avatar {
        width: 40px;
        height: 40px;
    }

    .chat-left {
        margin-left: 10px;
        margin-top: 10px;
    }

    .chat-right {
        margin-top: 10px;
    }

    .chat-left > div {
        margin-left: 3px;
        margin-bottom: 5px;
    }

    .chat-right > div {
        margin-right: 3px;
        margin-bottom: 5px;
    }

    .username {
        display: inline-block;
        color: #8c8c8c;
        font-size: 13px;
    }

    .content-span {
        padding: 2px 5px;
        background: green;
        color: white;
        border-radius: 5px;
        max-width: 250px;
        display: inline-block;
        word-break: break-all;
    }
</style>
