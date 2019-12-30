<?php

namespace App\Exports;

use App\Presence;
use App\Invitation;
use DB;
use Session;
use Maatwebsite\Excel\Concerns\FromCollection;

class PresenceExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
    	$data = Presence::select(DB::raw("id, invitation_id, min(created_at) as start_time, max(created_at) as end_time"))->where('event_id',Session::get('event_id'))->where('invitation_id','>',0)->with(['invitation'])->orderBy('created_at','asc')->groupBy('invitation_id')->get();

    	$arr[] = [
    			'Kode',
                'Nama',
                'E-Mail ',
                'Telp ',
    			'Perusahaan ',
                'Tempat Lahir ',
                'Tanggal Lahir ',
    			'Check In'
    		];
    	foreach ($data as $key) {
    		if($key->invitation->user_type_id==2){
                $arr[] = [
        			$key->invitation->reg_number,
                    $key->invitation->name,
                    $key->invitation->email,
                    $key->invitation->phone,
        			$key->invitation->company,
                    $key->invitation->custom_field_1,
                    $key->invitation->custom_field_2,
        			$key->start_time
        		];
            }
    	}


        $data = Invitation::where('event_id',Session::get('event_id'))->where('user_type_id',2)->whereNotIn('id',array_values($data->toArray()))->get();

        foreach ($data as $key) {
                $arr[] = [
                    $key->reg_number,
                    $key->name,
                    $key->email,
                    $key->phone,
                    $key->company,
                    $key->custom_field_1,
                    $key->custom_field_2,
                    ''
                ];
        }

        return collect($arr);
    }
}
