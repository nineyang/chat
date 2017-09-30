<?php

namespace App\Console\Commands;

use App\Message;
use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;

class Swoole extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'swoole:action {action}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'swoole command';

    /**
     * @var Message
     */
    protected $message;

    /**
     * @var User
     */
    protected $user;

    /**
     * Swoole constructor.
     * @param Message $message
     * @param User $user
     */
    public function __construct(Message $message, User $user)
    {
        parent::__construct();
        $this->message = $message;
        $this->user = $user;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $action = $this->argument('action');
        switch ($action) {
            case 'start':
                $this->start();
                break;
            case 'stop':
                $this->stop();
                break;
            case 'restart':
                $this->restart();
                break;
        }
    }

    /**
     * 开启websocket
     */
    private function start()
    {
        $ws = new \swoole_websocket_server(config('swoole.host'), config('swoole.port'));
        $ws->on('open', function ($ws, $request) {
//            $ws->push($request->fd, "hello, welcome\n");
        });

        //监听WebSocket消息事件
        $ws->on('message', function ($ws, $frame) {
            $data = json_decode($frame->data, true);
            switch ($data['type']) {
                case 'connect':
                    Redis::sadd("room:{$data['room_id']}", $frame->fd);
//                    同时使用hash标识fd在哪个房间
                    Redis::hset('room', $frame->fd, $data['room_id']);
                    break;
                case 'message':
//                    入库
                    $message = [
                        'content' => $data['message'],
                        'user_id' => $data['user_id'],
                        'room_id' => $data['room_id'],
                        'created_at' => time()
                    ];
//                    $this->message->fill($message)->save();
                    Message::create($message);
                    $user = $this->user->find($data['user_id']);
//                    防止注入信息，如果没有找到该用户就直接跳出
                    if (!$user) {
                        break;
                    }
                    $returnMessage = json_encode([
                        'message' => $data['message'],
                        'user' => [
                            'id' => $user->id,
                            'name' => $user->name
                        ]
                    ]);
                    $members = Redis::smembers("room:{$data['room_id']}");
                    foreach ($members as $fd) {
                        $ws->push($fd, $returnMessage);
                    }
                    break;
                case 'close':
//                    移除
                    var_dump($frame->fd);
                    Redis::srem("room:{$data['room_id']}", $frame->fd);
                    break;
            }
//            群发
//            foreach ($ws->connections as $connect) {
//                $ws->push($connect, "{$frame->data}");
//            }
        });

        $ws->on('close', function ($ws, $fd) {
//            获取fd所对应的房间号
            $room_id = Redis::hget('room' , $fd);
            Redis::srem("room:{$room_id}", $fd);

        });

        $ws->start();
    }

    /**
     * 停止websocket
     */
    private function stop()
    {

    }

    /**
     * 重启
     */
    private function restart()
    {

    }
}
