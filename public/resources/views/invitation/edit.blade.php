@extends('layouts.app')

@section('content')
<div class="">
    
    <h2>Ubah Data Tamu</h2>
    <form method="POST" action="{{route('invitation.update',[$invitation->id])}}">
    	<input type="hidden" name="_method" value="PUT">
    	@include('invitation._form')
    </form>

</div>
@endsection
