<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PollingQuestion extends Model
{
    
    protected $table = "ms_polling_question";
    public function polling()
    {
        return $this->belongsTo('App\Polling');
    }
    protected $fillable = [
        'content', 'polling_id','event_id'
    ];
}
