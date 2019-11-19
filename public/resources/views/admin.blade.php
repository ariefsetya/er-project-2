@extends('layouts.app')

@section('content')
<div class="row">
	<div class="col-md-12"><h2>Selamat Datang, {{Auth::user()->name}}!</h2></div>
	<hr>
	<div class="col-md-6">
		<div class="card mb-3">
		  <div class="card-header text-white bg-primary text-center">
		  	<h1>{{number_format((\App\Invitation::count()/\App\EventDetail::where('name','invitation_total')->first()->content)*100,2)}}%</h1>
		  </div>
		  <div class="card-body">
			  <div class="row">
			  	<div class="col-md-6 text-center">
			  		<div class="col-md-12">UNDANGAN</div>
			  		<div class="col-md-12"><h2><strong>{{\App\EventDetail::where('name','invitation_total')->first()->content}}</strong></h2></div>
			  	</div>
			  	<div class="col-md-6 text-center">
			  		<div class="col-md-12">TAMU IKUT QUIZ</div>
			  		<div class="col-md-12"><h2><strong>{{\App\Invitation::count()}}</strong></h2></div>
			  	</div>
			  </div>
		  </div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="card mb-3">
		  <div class="card-header text-white bg-primary text-center">
		  	<h1>{{number_format((sizeof(\App\Presence::where('product_id','>',0)->groupBy('uuid')->get())/\App\EventDetail::where('name','invitation_total')->first()->content)*100,2)}}%</h1>
		  </div>
		  <div class="card-body">
			  <div class="row">
			  	<div class="col-md-6 text-center">
			  		<div class="col-md-12">UNDANGAN</div>
			  		<div class="col-md-12"><h2><strong>{{\App\EventDetail::where('name','invitation_total')->first()->content}}</strong></h2></div>
			  	</div>
			  	<div class="col-md-6 text-center">
			  		<div class="col-md-12">TAMU SCAN PRODUK</div>
			  		<div class="col-md-12"><h2><strong>{{sizeof(\App\Presence::where('product_id','>',0)->groupBy('uuid')->get())}}</strong></h2></div>
			  	</div>
			  </div>
		  </div>
		</div>
	</div>
</div>
@endsection
