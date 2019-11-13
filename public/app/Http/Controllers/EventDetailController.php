<?php

namespace App\Http\Controllers;

use App\EventDetail;
use Illuminate\Http\Request;

class EventDetailController extends Controller
{
    public function index()
    {
        $data['event_detail'] = EventDetail::all();
        return view('event_detail.index')->with($data);
    }
    public function create()
    {
        return view('event_detail.add');
    }
    public function store(Request $request)
    {
        EventDetail::create($request->all());

        return redirect()->route('event_detail.index');
    }
    public function edit($id)
    {
        $data['event_detail'] = EventDetail::find($id);
        return view('event_detail.edit')->with($data);
    }
    public function update(Request $request, $id)
    {
        $inv = EventDetail::find($id);
        $inv->fill($request->all());
        $inv->save();

        return redirect()->route('event_detail.index');
    }
    public function destroy($id)
    {
        EventDetail::find($id)->delete();
        return redirect()->route('event_detail.index');
    }
}
