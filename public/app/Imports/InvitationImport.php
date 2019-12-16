<?php

namespace App\Imports;

use App\Invitation;
use Session;
use Maatwebsite\Excel\Concerns\ToModel;

class InvitationImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if($row[0]!='code'){
            return new Invitation([
                'event_id'=>Session::get('event_id'),
                'country_id'=>100,
                'user_type_id'=>2,
                'reg_number'=>$row[0],
                'name'=>$row[1],
                'email'=>$row[2],
                'phone'=>$row[3],
                'company'=>$row[4],
                'custom_field_1'=>$row[5],
                'custom_field_2'=>$row[6],
                'custom_field_3'=>$row[7]
            ]);
        }
    }
}
