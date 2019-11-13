<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Presence extends Model
{
    protected $table = "tr_presence";
    public function invitation()
    {
        return $this->belongsTo('App\Invitation')->withDefault();
    }
}
