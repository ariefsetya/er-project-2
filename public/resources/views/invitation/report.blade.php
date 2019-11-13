@extends('layouts.app')

@section('content')
<div class="">
    <h2>Laporan Kehadiran</h2>
    <table class="table for_datatables">
    	<thead>
    		<tr>
	    		<th>Nama</th>
	    		<th>Perusahaan</th>
                <th>Check In</th>
	    	</tr>
    	</thead>
    	<tbody>
    		@foreach($presence as $key)
    			<tr>
    				<td>{{$key->invitation->name}}</td>
                    <td>{{$key->invitation->company}}</td>
    				<td>{{$key->start_time}}</td>
    			</tr>
    		@endforeach
    	</tbody>
    </table>
</div>
@endsection
