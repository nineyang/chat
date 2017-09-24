/**
 * Created by sf on 2017/9/24.
 */
var ws, name;

// 创建websocket
ws = new WebSocket("ws://192.168.0.102:9130");
// 当socket连接打开时，输入用户名
ws.onopen = onopen;
// 当有消息时根据消息类型显示不同信息
ws.onmessage = onmessage;
ws.onclose = function () {
    console.log("连接关闭，定时重连");
};
ws.onerror = function () {
    console.log("出现错误");
};

function onopen() {

    var name = 'nine', data = '{"type":"1","user":"' + name + '"}';

    ws.send(data);
}

function onmessage(e) {
    var data = eval("(" + e.data + ")");
    var info = $('#chatinfo').html();
    console.log(data);
}

$('#send').click(function (e) {
    var data = {
        'msg': 'helloworld'
    };
    ws.send(JSON.stringify(data));
});

