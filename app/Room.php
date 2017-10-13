<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Room extends Model
{
    /**
     * @var string
     */
    protected $table = 'room';

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var array
     */
    protected $fillable = [
        'user_id',
        'title',
        'created_at',
        'updated_at',
        'is_private',
        'cipher',
        'cover'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function message()
    {
        return $this->hasMany(Message::class);
//        return $this->morphMany(Message::class , 'room');
    }

    /**
     * 判断用户是否加入
     * @param $roomId
     * @param RoomJoin $join
     * @return bool
     */
    public function checkUserJoined($roomId, RoomJoin $join)
    {
        return $join->where([
                ['status', '=', config('status.room_join.available')],
                ['user_id', '=', Auth::user()->id],
                ['room_id', '=', $roomId]
            ])->exists();
    }
}
