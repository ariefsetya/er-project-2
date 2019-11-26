<?php

namespace App\Http\Controllers;

use App\Invitation;
use App\Presence;
use App\Country;
use App\PollingParticipant;
use App\PollingResponse;
use App\ProductResponse;
use DB;
use Session;
use Illuminate\Http\Request;
use App\Exports\PresenceExport;
use Maatwebsite\Excel\Facades\Excel;

class InvitationController extends Controller
{

    public function index()
    {
        $data['invitation'] = Invitation::where('event_id',Session::get('event_id'))->with(['country'])->get();
        return view('invitation.index')->with($data);
    }
    public function create()
    {
        $data['country'] = Country::all();
        return view('invitation.add')->with($data);
    }
    public function store(Request $request)
    {
        Invitation::create($request->all());

        return redirect()->route('invitation.index');
    }
    public function edit($id)
    {
        $data['country'] = Country::all();
        $data['invitation'] = Invitation::where('event_id',Session::get('event_id'))->whereId($id);
        return view('invitation.edit')->with($data);
    }
    public function update(Request $request, $id)
    {
        $inv = Invitation::where('event_id',Session::get('event_id'))->whereId($id);
        $inv->fill($request->all());
        $inv->save();

        return redirect()->route('invitation.index');
    }
    public function destroy($id)
    {
        Invitation::where('event_id',Session::get('event_id'))->whereId($id)->delete();
        return redirect()->route('invitation.index');
    }
    public function report()
    {
        $data['presence'] = Presence::select(DB::raw("id, invitation_id, min(created_at) as start_time, max(created_at) as end_time"))->where('event_id',Session::get('event_id'))->where('invitation_id','>',0)->with(['invitation'])->orderBy('created_at','asc')->groupBy('invitation_id')->get();
        // dd($data);
        return view('invitation.report')->with($data);
    }
    public function export_excel()
    {
        return Excel::download(new PresenceExport, 'laporan_kehadiran.xlsx');
    }
    public function clear($id)
    {
        $inv = Invitation::where('event_id',Session::get('event_id'))->whereId($id)->first();
        $inv->need_login = 1;
        $inv->save();

        Presence::where('event_id',Session::get('event_id'))->where('invitation_id',$id)->delete();

        return redirect()->route('invitation.index');
    }
    public function reset()
    {
        Invitation::where('event_id',Session::get('event_id'))->where('id','>','1')->delete();
        Presence::where('event_id',Session::get('event_id'))->delete();
        PollingParticipant::where('event_id',Session::get('event_id'))->delete();
        PollingResponse::where('event_id',Session::get('event_id'))->delete();

        return redirect()->route('invitation.index');
    }
}
