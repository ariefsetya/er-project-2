@extends('layouts.app')

@section('content')
<div class="">
    
    <h2>Tambah Data Tamu</h2>
    <form method="POST" action="{{route('invitation.store')}}">
    	@include('invitation._form')
    </form>

</div>
@endsection
