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
}
