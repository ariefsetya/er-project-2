<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Event;
use App\EventDetail;
use App\Invitation;
use Str;

class EventController extends Controller
{
    public function create_event($name,$location,$date)
    {
    	$evt = Event::create([
    		'code'=>Str::slug($name),
    		'name'=>$name,
    		'location'=>$location,
    		'date'=>$date,
    	]);

    	$data = [
	    	['event_id'=>$evt->id,'type'=>'text','name'=>'success_login','content'=>'Berhasil masuk'],
			['event_id'=>$evt->id,'type'=>'text','name'=>'failed_login','content'=>'Silahkan ulangi atau hubungi panitia'],
			['event_id'=>$evt->id,'type'=>'text','name'=>'next_survey_button','content'=>'SELANJUTNYA'],
			['event_id'=>$evt->id,'type'=>'text','name'=>'finish_survey_button','content'=>'SELESAI'],
			['event_id'=>$evt->id,'type'=>'text','name'=>'finish_survey_alert','content'=>'TERIMA KASIH TELAH MENGIKUTI SURVEY'],
			['event_id'=>$evt->id,'type'=>'text','name'=>'already_login','content'=>'Anda sudah login pada device lain'],
			['event_id'=>$evt->id,'type'=>'text','name'=>'invitation_total','content'=>'250'],
			['event_id'=>$evt->id,'type'=>'text','name'=>'idle','content'=>'0'],
			['event_id'=>$evt->id,'type'=>'text','name'=>'greeting_text','content'=>'Welcome'],
			['event_id'=>$evt->id,'type'=>'text','name'=>'logout_button_visibility','content'=>'1'],
			['event_id'=>$evt->id,'type'=>'text','name'=>'website_title','content'=>'Your '.$name.' Website'],
			['event_id'=>$evt->id,'type'=>'image','name'=>'website_header_logo','content'=>'https://core.e-guestbook.com/img/HEADER.png']
		];

		foreach ($data as $key) {
			EventDetail::create($key);
		}

		$inv = [
			'event_id'=>$evt->id,
			'name'=>'Administrator',
			'country_id'=>100,
			'phone'=>83870002220,
			'company'=>'Event Corp.',
			'email'=>'eventwebsiteid@gmail.com',
			'need_login'=>1,
			'user_type_id'=>1,
		];

		Invitation::create($inv);

		$data['event'] = $evt;
		$data['detail'] = $data;
		$data['user'] = $inv;

		return response()->json($data);

    }
}
