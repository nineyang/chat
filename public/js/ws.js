/**
 * Created by sf on 2017/9/24.
 */
var ws, name, currUser;
var default_avatar = '/' + $('.default-value').data('default-avatar');
var room_id = $('.default-value').data('room-id');

currUser = $('.default-value').data('user-id');
ws = new WebSocket("ws://127.0.0.1:9502");
ws.onopen = function (evt) {
//    发送房间号相关信息，以识别connect id
    var data = {
        room_id: room_id,
        user_id: currUser,
        type: 'connect'
    };
    ws.send(JSON.stringify(data));
};

//滚动
function changeHight() {
    var beforeHeight = $(".content").scrollTop();
    $(".content").scrollTop($(".content").scrollTop() + 20);
    var afterHeight = $(".content").scrollTop();
    if (beforeHeight != afterHeight) {
        setTimeout("changeHight()", 5);
    }
}

//一开始就滚动到最下面
setTimeout("changeHight()", 5);

// 当有消息时根据消息类型显示不同信息
ws.onmessage = function (evt) {
    var data = JSON.parse(evt.data);
    //判断是join还是message
    if (data.type == 'message') {
        if (data.user.id == currUser) {
            $('.content').append('<div class="clearfix"></div> <div class="chat-right"> <img src="' + default_avatar + '" alt="" class="avatar pull-right"> <div class="pull-right"> <span class="username username-right">' + data.user.name + '</span> <br> <div class="content-span">' + data.message + '</div> </div> </div>');
        } else {
            $('.content').append('<div class="clearfix"></div> <div class="chat-left"> <img src="' + default_avatar + '" alt="" class="avatar pull-left"> <div class="pull-left"> <span class="username username-left">' + data.user.name + '</span> <br> <div class="content-span">' + data.message + '</div> </div> </div>');
        }
    } else if (data.type == 'join') {
        $('.all').text(data.message.all);
        $('.online').text(data.message.online);
        $('.content').append('<span class="joined">' + data.user.name + '加入了房间</span>');
    } else if (data.type == 'leave') {
        $('.all').text(data.message.all);
        $('.online').text(data.message.online);
        $('.content').append('<span class="joined">' + data.user.name + '离开了房间</span>');
    }

    //滚到底部
    setTimeout("changeHight()", 5);
};
ws.onclose = function () {
    //    发送房间号相关信息，以识别connect id
    var data = {
        room_id: room_id,
        user_id: currUser,
        type: 'close'
    };
    ws.send(JSON.stringify(data));
};
ws.onerror = function () {
    console.log("出现错误");
};

var send = function (e) {
    var data = {
        'message': $('.wait-send').val(),
        'user_id': currUser,
        'room_id': room_id,
        'type': 'message'
    };
    ws.send(JSON.stringify(data));
    //清空数据
    $('.wait-send').val('');
};

$('#send').click(function (e) {
    send(e);
});

//监听回车
$(document).keydown(function (e) {
    //shift+回车就是换行
    if (e.which == 13) {
        e.preventDefault();
        if (e.shiftKey == 1) {
            var currVal = $('.wait-send').val();
            $('.wait-send').val(currVal += "\r\n");
        } else {
            send(e);
        }
    }
});



