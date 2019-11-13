@extends('layouts.app')

@section('content')
<div class="">
    <h2>Data Detail Event
    <a class="btn btn-primary float-right" href="{{route('event_detail.create')}}">Tambah</a></h2>
    <table class="table for_datatables">
    	<thead>
    		<tr>
	    		<th>Nama</th>
                <th>Isi</th>
	    		<th colspan="2">Action</th>
	    	</tr>
    	</thead>
    	<tbody>
    		@foreach($event_detail as $key)
    			<tr>
    				<td>{{$key->name}}</td>
                    <td>{{$key->content}}</td>
    				<td><a class="btn btn-warning" href="{{route('event_detail.edit',[$key->id])}}">Edit</a></td>
    				<td><form method="POST" action="{{route('event_detail.destroy',[$key->id])}}">{{csrf_field()}}<input type="hidden" name="_method" value="DELETE">
    					<button type="submit" class="btn btn-danger">Delete</button></form></td>
    			</tr>
    		@endforeach
    	</tbody>
    </table>
</div>
@endsection
