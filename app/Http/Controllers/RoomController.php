<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRoom;
use App\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
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
        $this->room->fill($data)->save();

        return redirect('room/lists')->with('message' , 'created success');
    }

    public function lists()
    {
        $rooms = $this->room->paginate(10);
        return view('lists' , ['rooms' => $rooms]);
    }
}
