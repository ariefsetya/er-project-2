<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventDetail extends Model
{
    protected $table = "ms_event_detail";
    protected $fillable = [
        'event_id', 'name', 'type','content'
    ];
}
