<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Presence;
use Session;
use Illuminate\Support\Str;

class Firewall
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user_id = 0;

        if(Auth::check()){
            $user_id = Auth::user()->id;

            if(Auth::user()->need_login==1){
                Auth::logout();
                return redirect()->route('home');
            }
        }

        if(!Session::has('uuid')){
            Session::put('uuid',Str::uuid()->toString());
        }
        
        $pre = new Presence;
        $pre->event_id = 1;
        $pre->uri = $request->url();
        $pre->invitation_id = $user_id;
        $pre->save();

        return $next($request);
    }
}
