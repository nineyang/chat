<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRoom;
use App\Room;
use App\RoomJoin;
use App\Message;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Mockery\Exception;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Redis;

class RoomController extends Controller
{
    /**
     * @var Room
     */
    public $model;

    /**
     * @var RoomJoin
     */
    public $join;

    /**
     * @var Message
     */
    public $message;

    /**
     * RoomController constructor.
     * @param Room $room
     * @param RoomJoin $join
     * @param Message $message
     */
    public function __construct(Room $room, RoomJoin $join, Message $message)
    {
        $this->middleware('auth');
        $this->model = $room;
        $this->join = $join;
        $this->message = $message;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('home');
    }

    /**
     * 表单
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('room.add');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Request $request)
    {
//        判断是否存在
        $room = $this->checkAndGet($request->id);
//        判断是否有权限
        if ($room->user_id != $request->user()->id) {
            abort(403, '无权操作');
        }

        return view('room.edit', ['room' => $room]);
    }

    /**
     * @param StoreRoom $request
     * @return mixed
     */
    public function add(StoreRoom $request)
    {
        $file = $request->file('cover');
        $data = [
            'title' => $request->get('title'),
            'is_private' => $request->get('isPrivate'),
            'cipher' => $request->get('cipher') ? bcrypt($request->get('cipher')) : '',
            'user_id' => $request->user()->id,
            'created_at' => time(),
            'updated_at' => time()
        ];
//        存储文件
        if ($file) {
            $data['cover'] = Storage::disk('public')->putFile(date('Y/m'), $file);
        }
        $this->model->fill($data)->save();

        return redirect('room/lists')->with('message', 'created success');
    }

    /**
     * @param StoreRoom $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(StoreRoom $request, $id)
    {
        $file = $request->file('cover');
        $data = [
            'title' => $request->get('title'),
            'is_private' => $request->get('isPrivate'),
            'cipher' => $request->get('cipher') ? bcrypt($request->get('cipher')) : '',
            'user_id' => $request->user()->id,
            'updated_at' => time()
        ];
//        存储文件
        if ($file) {
            $data['cover'] = Storage::disk('public')->putFile(date('Y/m'), $file);
        }
        $this->model->where('id', $id)
            ->update($data);

        return redirect('room/lists')->with('message', 'updated success');
    }

    /**
     * 我加入的和我创建的
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function lists()
    {
        $rooms = $this->model->paginate(config('room.page_size'));
        return view('room.lists', ['rooms' => $rooms]);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function chat($id)
    {
//        判断房间是否存在
        $room = $this->checkAndGet($id);
//        判断用户是否加入
        if (Auth::user()->id != $room->user_id && !$this->model->checkUserJoined($id, $this->join)) {
            abort(403, '请先加入房间');
        }
        $latestMessages = $this->message->getLatestMessage($id, config('room.message_page_size'));
        foreach ($latestMessages as $message) {
            $message->content = nl2br($message->content);
        }
//        获取圈子成员
        $memberNum = $this->join->memberNum($id);

        return view('room.chat', ['room' => $room, 'messages' => $latestMessages, 'memberNum' => $memberNum]);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function join(Request $request, $id)
    {
        $room = $this->checkAndGet($id);
//        已经加入过了
        if ($this->model->checkUserJoined($id, $this->join) || Auth::user()->id == $room->user_id) {
            return redirect("room/{$id}");
        }

//        判断是否需要密码
        if ($room->isPrivate) {
            return redirect('room/lists')->with('modal', '请输入密码');
        }

//        加入
        $data = [
            'user_id' => Auth::user()->id,
            'room_id' => $id,
            'created_at' => time(),
            'updated_at' => time()
        ];
        $this->join->fill($data)->save();
        return redirect("room/{$id}")->with('message', 'joined success');
    }
}
