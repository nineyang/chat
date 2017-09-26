<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRoom;
use App\Room;
use App\RoomJoin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

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

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function join(Request $request, $id)
    {
        $room = $this->checkAndGet($id);
//        已经加入过了
        if ($this->model->checkUserJoined($id, $this->join) || Auth::user()->id == $room->user_id) {
            return response()->json(['status' => 0, 'message' => 'have joined']);
        }

//        判断是否需要密码
        if ($room->is_private && !Hash::check($request->cipher, $room->cipher)) {
            return response()->json(['status' => 2, 'message' => '密码不正确']);
        }

//        加入
        $data = [
            'user_id' => Auth::user()->id,
            'room_id' => $id,
            'created_at' => time(),
            'updated_at' => time()
        ];
        $this->join->fill($data)->save();
        return response()->json(['status' => 1, 'message' => 'joined success']);
    }
}
