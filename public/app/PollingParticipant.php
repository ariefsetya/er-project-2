<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PollingParticipant extends Model
{
    protected $casts = [
        'created_at' => 'date:H:i:s',
    ];

    protected $table = "tr_polling_participant";
    protected $fillable = [
        'invitation_id', 'polling_id', 'is_winner'
    ];
    public function invitation()
    {
        return $this->belongsTo('App\Invitation')->withDefault();
    }
    public function polling()
    {
        return $this->belongsTo('App\Polling')->withDefault();
    }
}
