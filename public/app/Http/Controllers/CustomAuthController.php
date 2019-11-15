<?php

namespace App\Http\Controllers;

use Auth;
use App\Presence;
use App\EventDetail;
use App\Invitation;
use App\User;
use Illuminate\Http\Request;

class CustomAuthController extends Controller
{

    public function phoneLogin(Request $r)
    {	
		$country_id = $r->input('country_id');
		$phone = ltrim($r->input('phone'),"0");
		if(User::where(['country_id'=>$country_id,'phone'=>$phone])->exists()){
			$user = User::where(['country_id'=>$country_id,'phone'=>$phone])->first();
			
			if($user->user_type_id==1){
				
				Auth::loginUsingId($user->id);

				$inv = Invitation::find($user->id);
				$inv->need_login = 0;
				$inv->save();
				
				return redirect()->route('admin')->with(['message'=>EventDetail::whereName('success_login')->first()->content]);

			}else if($user->user_type_id==2){

				if(Presence::where('invitation_id',$user->id)->exists()){

					return redirect()->route('loginPage')->with(['message'=>EventDetail::whereName('already_login')->first()->content]);

				}else{

					Auth::loginUsingId($user->id);

					$inv = Invitation::find($user->id);
					$inv->need_login = 0;
					$inv->save();

					return redirect()->route('home')->with(['message'=>EventDetail::whereName('success_login')->first()->content]);
				}
			}
		}else{
			return redirect()->route('loginPage',[1])->with(['message'=>EventDetail::whereName('failed_login')->first()->content]);
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
			Auth::logout();
		}
		return redirect()->route('home');
    }
}
