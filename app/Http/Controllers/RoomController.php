<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRoom;
use App\Room;
use App\RoomJoin;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Mockery\Exception;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;

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
     * RoomController constructor.
     * @param Room $room
     * @param RoomJoin $join
     */
    public function __construct(Room $room, RoomJoin $join)
    {
        $this->middleware('auth');
        $this->model = $room;
        $this->join = $join;
    }

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
        return view('add');
    }

    public function edit(Request $request)
    {
//        判断是否存在
        $room = $this->checkAndGet($request->id);
//        判断是否有权限
        if ($room->user_id != $request->user()->id) {
            abort(403 , '无权操作');
        }

        return view('edit', ['room' => $room]);
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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function lists()
    {
        $rooms = $this->model->paginate(config('room.page_size'));
        return view('lists', ['rooms' => $rooms]);
    }

    public function chat($id)
    {
//        判断房间是否存在
        $room = $this->checkAndGet($id);
//        判断用户是否加入
        if (!$this->model->checkUserJoined($id, $this->join)) {
            abort(403 , '请先加入房间');
        }
    }
}
