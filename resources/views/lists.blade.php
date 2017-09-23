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
                                <img src="{{asset(empty($room->cover) ? config('room.default_room_pic') : $room->cover)}}">
                                <div class="caption">
                                    <h4>{{$room->title}}</h4>
                                    <p>
                                        <a href="#" class="btn btn-primary" role="button">编辑</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    {{--room end--}}

                </div>

            </div>
        </div>

        {{--<nav aria-label="Page navigation">--}}
        {{--<ul class="pagination">--}}
        {{--<li>--}}
        {{--<a href="#" aria-label="Previous">--}}
        {{--<span aria-hidden="true">&laquo;</span>--}}
        {{--</a>--}}
        {{--</li>--}}
        {{--<li><a href="#">1</a></li>--}}
        {{--<li><a href="#">2</a></li>--}}
        {{--<li><a href="#">3</a></li>--}}
        {{--<li><a href="#">4</a></li>--}}
        {{--<li><a href="#">5</a></li>--}}
        {{--<li>--}}
        {{--<a href="#" aria-label="Next">--}}
        {{--<span aria-hidden="true">&raquo;</span>--}}
        {{--</a>--}}
        {{--</li>--}}
        {{--</ul>--}}
        {{--</nav>--}}

    </div>
    {{ $rooms->links('pagination.default') }}

@endsection

<style>
    .row .thumbnail img {
        height:150px;
    }
</style>
