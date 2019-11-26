<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'event_id','name', 'email','phone','reg_number','country_id','company'
    ];

    protected $table = "ms_invitation";
    
    protected $attributes = [
        'custom_field_1'=>'',
        'custom_field_2'=>'',
        'custom_field_3'=>''
    ];
}
