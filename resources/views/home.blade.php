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
                                    <h4>{{str_limit( $room->title , 20)}}</h4>
                                    <p>
                                        <button data-id="{{$room->id}}" data-private="{{$room->is_private}}"
                                                class="btn btn-primary join">加入
                                        </button>
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

    <div class="modal fade" id="joinModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">请输入密码</h4>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="recipient-name" class="control-label">密码:</label>
                            <input type="text" id="cipher" class="form-control" id="recipient-name" required>
                        </div>
                        {{--<div class="form-group">--}}
                        {{--<label for="message-text" class="control-label">Message:</label>--}}
                        {{--<textarea class="form-control" id="message-text"></textarea>--}}
                        {{--</div>--}}
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                    <button type="button" class="btn btn-primary" id="confirm" data-container="body"
                            data-toggle="popover" data-placement="bottom" data-content="密码错误">加入
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{ $rooms->links('pagination.default') }}

    <script>
        var cipher = $('#cipher').val(), that = $(this);
        var id, token = $('meta[name="csrf-token"]').attr('content');
        $('.join').click(function () {
            id = $(this).data('id');
            if ($(this).data('private') == 1) {
                $('#joinModal').modal('show');
            } else {
                $.post("/api/room/" + id + "/join", {'_token': token, 'cipher': cipher}, function (res) {
                    if (res.status == 0 || res.status == 1) {
                        location.href = "/room/" + id;
                    } else {
                        that.attr('data-content', res.message);
                        that.popover('show');
                    }
                });
            }
        });

        $('#confirm').click(function () {
            $.post("/api/room/" + id + "/join", {'_token': token, 'cipher': cipher}, function (res) {
                if (res.status == 0 || res.status == 1) {
                    location.href = "/room/" + id;
                } else {
                    that.attr('data-content', res.message);
                    that.popover('show');
                }
            });
        });

        $('#joinModal').on('hidden.bs.modal', function (e) {
            $('#confirm').popover('hide');
        });

    </script>
@endsection

<style>
    .row .thumbnail img {
        height: 150px;
        cursor: pointer;
    }
</style>
