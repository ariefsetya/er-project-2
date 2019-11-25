<?php

namespace App\Http\Controllers;

use App\Polling;
use App\PollingType;
use App\PollingResponse;
use App\PollingQuestion;
use DB;
use Illuminate\Http\Request;

class PollingController extends Controller
{

    public function index()
    {
        $data['polling'] = Polling::with(['polling_type'])->paginate(10);
        return view('polling.index')->with($data);
    }
    public function create()
    {
        $data['polling_type'] = PollingType::all();
        return view('polling.add')->with($data);
    }
    public function store(Request $request)
    {
        Polling::create($request->all());

        return redirect()->route('polling.index');
    }
    public function edit($id)
    {
        $data['polling_type'] = PollingType::all();
        $data['polling'] = Polling::find($id);
        return view('polling.edit')->with($data);
    }
    public function show($id)
    {
        $data['polling'] = Polling::find($id);
        $arr = [];
        foreach (PollingQuestion::where('polling_id',$id)->get() as $key) {

            $key['polling_response'] = PollingResponse::select(DB::raw('id, polling_answer_id, count(id) as total'))->where('polling_question_id',$key->id)->with(['polling_answer'])->groupBy('polling_answer_id')->get();
            $arr[] = $key;
        }
        // dd($arr);
        $data['result'] = $arr;
        return view('polling.show')->with($data);
    }
    public function detail($polling_id,$question_id)
    {
        $data['polling'] = Polling::find($polling_id);
        $data['polling_question'] = PollingQuestion::find($question_id);

        $data['polling_response'] = PollingResponse::select(DB::raw('id, polling_answer_id, count(id) as total'))->where('polling_question_id',$question_id)->with(['polling_answer'])->groupBy('polling_answer_id')->get();
        return view('polling.detail')->with($data);
    }
    public function update(Request $request, $id)
    {
        $inv = Polling::find($id);
        $inv->fill($request->all());
        $inv->save();

        return redirect()->route('polling.index');
    }
    public function destroy($id)
    {
        Polling::find($id)->delete();
        return redirect()->route('polling.index');
    }
    public function report()
    {
        $data['polling'] = Polling::all();
        return view('polling.report')->with($data);
    }
    public function polling_response_reset($polling_id, $invitation_id)
    {
        PollingResponse::where('polling_id',$polling_id)->where('invitation_id',$invitation_id)->delete();
        PollingParticipant::where('polling_id',$polling_id)->where('invitation_id',$invitation_id)->delete();
        return redirect()->route('quiz_report',[$polling_id]);
    }
}
