<?php

namespace App\Http\Controllers;

use Auth;
use App\Presence;
use App\EventDetail;
use App\Invitation;
use App\User;
use Session;
use Illuminate\Http\Request;

class CustomAuthController extends Controller
{

    public function phoneLogin(Request $r)
    {	
		$country_id = $r->input('country_id');
		$phone = ltrim($r->input('phone'),"0");
		if(User::where('event_id',Session::get('event_id'))->where(['country_id'=>$country_id,'phone'=>$phone])->exists()){
			$user = User::where('event_id',Session::get('event_id'))->where(['country_id'=>$country_id,'phone'=>$phone])->first();
			
			if($user->user_type_id==1){
				
				Auth::loginUsingId($user->id);

				$inv = Invitation::where('event_id',Session::get('event_id'))->whereId($user->id)->first();
				$inv->need_login = 0;
				$inv->save();
				
				return redirect()->route('admin')->with(['message'=>EventDetail::where('event_id',Session::get('event_id'))->whereName('success_login')->first()->content]);

			}else if($user->user_type_id==2){

				if(Presence::where('invitation_id',$user->id)->exists() and $user->need_login==0){

					return redirect()->route('loginPage')->with(['message'=>EventDetail::where('event_id',Session::get('event_id'))->whereName('already_login')->first()->content]);

				}else{

					Auth::loginUsingId($user->id);

					$inv = Invitation::where('event_id',Session::get('event_id'))->whereId($user->id)->first();
					$inv->need_login = 0;
					$inv->save();

					return redirect()->route('home')->with(['message'=>EventDetail::where('event_id',Session::get('event_id'))->whereName('success_login')->first()->content]);
				}
			}
		}else{
			return redirect()->route('loginPage',[1])->with(['message'=>EventDetail::where('event_id',Session::get('event_id'))->whereName('failed_login')->first()->content]);
		}
    }
    public function loginPage()
    {	
        if(Auth::check()){
            return redirect()->route('home');
        }
		$data['country'] = \App\Country::all();
		return view('auth.login')->with($data);
    }
    public function logout()
    {
    	if(Auth::check()){

			$inv = Invitation::where('event_id',Session::get('event_id'))->whereId(Auth::user()->id)->first();
			$inv->need_login = 1;
			$inv->save();

			Auth::logout();

		}
    	
    	Session::flush();

		return redirect()->route('home');
    }
}
