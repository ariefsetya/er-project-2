@extends('layouts.guest')

@section('content')
<div class="text-center   col-md-3" style="margin:0 auto;">
    <div class="">
      <img class="mb-4 text-center" src="{{asset('img/HEADER.png')}}" alt="" style="width: 60%;">
    </div>
	<hr>
    <h3>{{\App\EventDetail::where('name','greeting_text')->first()->content}}<br>
    {{Auth::user()->name}}<br>
    {{Auth::user()->company}}</h3>
    <hr>
    @if(\App\EventDetail::where('name','idle')->first()->content==0)
        @foreach(\App\Polling::get() as $row)
        	@if($row->polling_type_id==3)
            	@if(Auth::check())
                    @if(\App\PollingResponse::where('invitation_id',Auth::user()->id)->count()==\App\PollingQuestion::where('polling_id',$row->id)->count())
                        <a class="btn btn-lg btn-secondary text-white col-md-12">{{$row->name}}</a>
                    @else
                        <a href="{{route('quiz_response',[$row->id])}}" class="btn btn-lg btn-dark col-md-12">{{$row->name}}</a>
                    @endif
            	@else
                    <a href="{{route('quiz_join',[$row->id])}}" class="btn btn-lg btn-dark col-md-12">{{$row->name}}</a>
                @endif
            @else
                @if(\Session::has('polling_'.$row->id))
                    <a class="btn btn-lg btn-secondary text-white col-md-12">{{$row->name}}</a>
                @else
                    <a href="{{route('polling_response',[$row->id])}}" class="btn btn-lg btn-dark col-md-12">{{$row->name}}</a>
                @endif
            @endif
            <hr>
        @endforeach
    @else
    <h2>Please scan again later</h2>
    @endif
    @if(\App\EventDetail::where('name','logout_button_visibility')->first()->content==0)
    <a href="{{route('logout')}}" class="btn btn-lg btn-dark col-md-12">Logout</a>
    @endif
</div>
@endsection