/**
 * Created by sf on 2017/9/24.
 */
var ws, name;

ws = new WebSocket("ws://127.0.0.1:9502");
ws.onopen = function (evt) {
    //websocket.readyState 属性：
    /*
     CONNECTING    0    The connection is not yet open.
     OPEN    1    The connection is open and ready to communicate.
     CLOSING    2    The connection is in the process of closing.
     CLOSED    3    The connection is closed or couldn't be opened.
     */
    console.log(ws.readyState);
};
// 当有消息时根据消息类型显示不同信息
ws.onmessage = function (evt) {
    console.log(evt);
};
ws.onclose = function () {
    console.log("连接关闭，定时重连");
};
ws.onerror = function () {
    console.log("出现错误");
};


$('#send').click(function (e) {
    var data = {
        'msg': 'helloworld'
    };
    ws.send(JSON.stringify(data));
});

