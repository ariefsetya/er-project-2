@extends('layouts.app')

@section('content')
<div class="row">
	<div class="col-md-12"><h2>Selamat Datang, {{Auth::user()->name}}!</h2></div>
	<hr>
	<div class="col-md-6">
		<div class="card mb-3">
		  <div class="card-header text-white bg-primary text-center">
		  	<h1>{{number_format((sizeof(\App\Presence::where('invitation_id','>',0)->where('event_id',Session::get('event_id'))->groupBy('invitation_id')->toArray())/(\App\Invitation::where('event_id',Session::get('event_id'))->where('user_type_id',1)->count()))*100,2)}}%</h1>
		  </div>
		  <div class="card-body">
			  <div class="row">
			  	<div class="col-md-6 text-center">
			  		<div class="col-md-12">UNDANGAN</div>
			  		<div class="col-md-12"><h2><strong>{{\App\Invitation::where('user_type_id',1)->where('event_id',Session::get('event_id'))->count()}}</strong></h2></div>
			  	</div>
			  	<div class="col-md-6 text-center">
			  		<div class="col-md-12">CHECK IN</div>
			  		<div class="col-md-12"><h2><strong>{{sizeof(\App\Presence::where('invitation_id','>',0)->where('event_id',Session::get('event_id'))->groupBy('invitation_id')->toArray())}}</strong></h2></div>
			  	</div>
			  </div>
		  </div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="card mb-3">
		  <div class="card-header text-white bg-primary text-center">
		  	<h1>{{number_format((sizeof(\App\Presence::where('invitation_id','>',0)->where('event_id',Session::get('event_id'))->groupBy('invitation_id')->toArray())/(\App\Invitation::where('user_type_id',1)->where('event_id',Session::get('event_id'))->count()))*100,2)}}%</h1>
		  </div>
		  <div class="card-body">
			  <div class="row">
			  	<div class="col-md-6 text-center">
			  		<div class="col-md-12">UNDANGAN</div>
			  		<div class="col-md-12"><h2><strong>{{\App\Invitation::where('user_type_id',1)->where('event_id',Session::get('event_id'))->count()}}</strong></h2></div>
			  	</div>
			  	<div class="col-md-6 text-center">
			  		<div class="col-md-12">CHECK IN</div>
			  		<div class="col-md-12"><h2><strong>{{sizeof(\App\Presence::where('invitation_id','>',0)->where('event_id',Session::get('event_id'))->groupBy('invitation_id')->toArray())}}</strong></h2></div>
			  	</div>
			  </div>
		  </div>
		</div>
	</div>
</div>
@endsection
