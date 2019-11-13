<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\PollingResponse;

class Polling extends Model
{
    
    protected $table = "ms_polling";
    public function polling_type()
    {
        return $this->belongsTo('App\PollingType')->withDefault();
    }
    protected $fillable = [
        'name', 'polling_type_id','event_id','finish_message'
    ];
}
