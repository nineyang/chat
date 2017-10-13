@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">

                <div class="row">
                    {{--room start--}}

                    @foreach($rooms as $room)
                        <div class="col-sm-6 col-md-4">
                            <div class="thumbnail">
                                <a target="_blank" href="{{url("room/$room->id")}}">
                                    <img src="{{asset(empty($room->cover) ? config('room.default_room_pic') : config('room.file_type') . $room->cover)}}"
                                         alt="{{$room->title}}">
                                </a>
                                <div class="caption">
                                    <h4>{{str_limit($room->title , 20 )}}</h4>
                                    <p>
                                        @if($room->user_id == Auth::user()->id)
                                            <a href="{{url("room/$room->id/edit")}}" class="btn btn-primary"
                                               role="button">编辑</a>
                                        @endif

                                        <a href="{{url("room/$room->id")}}" class="btn btn-primary"
                                           role="button">进入</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    {{--room end--}}

                </div>

            </div>
        </div>

    </div>
    {{ $rooms->links('pagination.default') }}
@endsection

<style>
    .row .thumbnail img {
        height: 150px;
        cursor: pointer;
    }
</style>
