<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $table = "ms_event";
    protected $fillable = [
        'code', 'name','location','date'
    ];
}
