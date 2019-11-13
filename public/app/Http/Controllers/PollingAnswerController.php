<?php

namespace App\Http\Controllers;

use App\PollingQuestion;
use App\PollingAnswer;
use App\Polling;
use Illuminate\Http\Request;

class PollingAnswerController extends Controller
{

    public function index()
    {
        $data['polling_answer'] = PollingAnswer::with(['polling_question'])->paginate(10);
        return view('polling_answer.index')->with($data);
    }
    public function create()
    {
        $data['polling_question'] = PollingQuestion::all();
        return view('polling_answer.add')->with($data);
    }
    public function store(Request $request)
    {
        PollingAnswer::create($request->all());

        return redirect()->route('polling_answer.index');
    }
    public function edit($id)
    {
        $data['polling_question'] = PollingQuestion::all();
        $data['polling_answer'] = PollingAnswer::find($id);
        return view('polling_answer.edit')->with($data);
    }
    public function update(Request $request, $id)
    {
        $inv = PollingAnswer::find($id);
        $inv->fill($request->all());
        $inv->save();

        return redirect()->route('polling_answer.index');
    }
    public function destroy($id)
    {
        PollingAnswer::find($id)->delete();
        return redirect()->route('polling_answer.index');
    }
}
