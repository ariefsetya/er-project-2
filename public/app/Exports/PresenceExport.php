<?php

namespace App\Exports;

use App\Presence;
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
    			'Nama',
    			'Nama Dealer',
    			'Check In'
    		];
    	foreach ($data as $key) {
    		$arr[] = [
    			$key->invitation->name,
    			$key->invitation->company,
    			$key->start_time
    		];
    	}

        return collect($arr);
    }
}
