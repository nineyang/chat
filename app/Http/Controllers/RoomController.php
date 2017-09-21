<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRoom;
use App\Room;
use Illuminate\Http\Request;
use Mockery\Exception;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;

class RoomController extends Controller
{
    /**
     * @var
     */
    public $room;

    /**
     * RoomController constructor.
     * @param Room $room
     */
    public function __construct(Room $room)
    {
        $this->middleware('auth');
        $this->room = $room;
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

    /**
     * 创建room
     * @param StoreRoom $request
     */
    public function add(StoreRoom $request)
    {
        $file = $request->file('cover');
        $data = [
            'title' => $request->get('title'),
            'is_private' => $request->get('isPrivate'),
            'cipher' => $request->get('cipher') ?? bcrypt($request->get('cipher')),
            'user_id' => $request->user()->id,
            'created_at' => time(),
            'updated_at' => time()
        ];
//        存储文件
        if ($file) {
            $data['cover'] = Storage::putFile(date('Y/m'), $file);
        }
        $res = $this->room->fill($data)->save();
    }

    public function lists()
    {
        return view('lists');
    }
}
