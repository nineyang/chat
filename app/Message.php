<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    /**
     * @var string
     */
    protected $table = 'message';

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var array
     */
    protected $fillable = [
        'user_id',
        'room_id',
        'status',
        'content',
        'created_at',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * 获取最近24小时内的消息
     * @param $room_id
     * @param $pageSize
     * @return \Illuminate\Support\Collection
     */
    public function getLatestMessage($room_id, $pageSize)
    {
//        暂时先获取全部数据好了
//        $time = time() - config('room.latest_time');
        return $this->leftJoin('users' , 'message.user_id' , '=' , 'users.id')
            ->select('message.content' , 'message.created_at' , 'users.id as user_id' , 'users.name as user_name')
            ->where('message.room_id' , '=' , $room_id)
            ->where('message.status' , '=' , config('status.message.available'))
//            ->where('message.created_at' , '>' , $time)
//            ->take($pageSize)
            ->get();
    }
}
