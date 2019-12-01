@extends('layouts.app')

@section('content')
<div class="">
    
    <h2>Ubah Data Detail Event</h2>
    <form method="POST" action="{{route('event_detail.update',[$event_detail->id])}}"  enctype="multipart/form-data">
    	<input type="hidden" name="_method" value="PUT">
    	@include('event_detail._form')
    </form>

</div>
@endsection
