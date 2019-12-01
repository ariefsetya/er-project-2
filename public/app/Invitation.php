<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    
    protected $table = "ms_invitation";

    public function country()
    {
        return $this->belongsTo('App\Country')->withDefault();
    }
    protected $fillable = [
        'name', 'email','phone','reg_number','country_id','company','user_type_id','custom_field_1','custom_field_2','custom_field_3','event_id'
    ];
}
