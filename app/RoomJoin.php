<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RoomJoin extends Model
{
    /**
     * @var string
     */
    protected $table = 'room_join';

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
        'created_at',
        'updated_at',
        'status'
    ];

    /**
     * @param $room_id
     * @return mixed
     */
    public function memberNum($room_id)
    {
        return $this->where([
            'room_id' => $room_id,
            'status' => 0
        ])->count();
    }
}
