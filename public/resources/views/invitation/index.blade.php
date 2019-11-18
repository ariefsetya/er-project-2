@extends('layouts.app')

@section('content')
<div class="">
    <h2>Data Tamu
        <div class="float-right">
    <a class="btn btn-primary" href="{{route('invitation.create')}}">Tambah</a>
    <a class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin me-reset data?')" href="{{route('invitation.reset')}}">Reset</a>
    </div>
</h2>
    <table class="table for_datatables">
    	<thead>
    		<tr>
	    		<th>Nomor Induk</th>
	    		<th>Nama</th>
	    		<th>Email</th>
	    		<th>Nomor HP</th>
	    		<th>Perusahaan</th>
	    		<th>Edit</th>
                <th>Delete</th>
                <th>Session</th>
	    	</tr>
    	</thead>
    	<tbody>
    		@foreach($invitation as $key)
    			<tr>
    				<td>{{$key->reg_number}}</td>
    				<td>{{$key->name}}</td>
    				<td>{{$key->email}}</td>
    				<td>+{{$key->country->phonecode."  ".$key->phone}}</td>
    				<td>{{$key->company}}</td>
    				<td><a class="btn btn-warning" href="{{route('invitation.edit',[$key->id])}}">Edit</a></td>
    				<td><form method="POST" action="{{route('invitation.destroy',[$key->id])}}">{{csrf_field()}}<input type="hidden" name="_method" value="DELETE">
    					<button type="submit" class="btn btn-danger">Delete</button></form></td>
                    <td><a class="btn btn-danger" href="{{route('invitation.clear',[$key->id])}}">Clear</a></td>
    			</tr>
    		@endforeach
    	</tbody>
    </table>
</div>
@endsection
