@extends('layouts.guest')

@section('content')
<div class="text-center   col-md-3" style="margin:0 auto;">
    <div class="">
      <img class="mb-4 text-center" src="{{asset('img/HEADER.png')}}" alt="" style="width: 100%;">
    </div>
	<hr>
    @foreach(\App\Polling::get() as $row)
    	@if($row->polling_type_id==3)
    	@if(Auth::check())
        <a href="{{route('quiz_response',[$row->id])}}" class="btn btn-lg btn-primary col-md-12">{{$row->name}}</a>
    	@else
        <a href="{{route('quiz_join',[$row->id])}}" class="btn btn-lg btn-primary col-md-12">Ikuti {{$row->name}}</a>
        @endif
        @else
        <a href="{{route('polling_response',[$row->id])}}" class="btn btn-lg btn-primary col-md-12">{{$row->name}}</a>
        @endif
        <hr>
    @endforeach
</div>
@endsection
