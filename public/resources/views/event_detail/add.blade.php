@extends('layouts.app')

@section('content')
<div class="">
    
    <h2>Tambah Data Detail Event</h2>
    <form method="POST" action="{{route('event_detail.store')}}">
    	@include('event_detail._form')
    </form>

</div>
@endsection
