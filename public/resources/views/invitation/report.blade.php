@extends('layouts.app')

@section('content')
<div class="">
    <h2>Laporan Kehadiran
    <a class="btn btn-primary float-right" href="{{route('invitation.export_excel')}}">Export</a></h2>
    <table class="table for_datatables">
    	<thead>
    		<tr>
	    		<th>Kode</th>
                <th>Nama</th>
	    		<th>Perusahaan</th>
                <th>E-Mail</th>
                <th>Telp</th>
                <th>Tempat Lahir</th>
                <th>Tanggal Lahir</th>
                <th>Check In</th>
	    	</tr>
    	</thead>
    	<tbody>
    		@foreach($presence as $key)
    			<tr>
    				<td>{{$key->invitation->reg_number}}</td>
                    <td>{{$key->invitation->name}}</td>
                    <td>{{$key->invitation->company}}</td>
                    <td>{{$key->invitation->email}}</td>
                    <td>{{$key->invitation->phone}}</td>
                    <td>{{$key->invitation->custom_field_1}}</td>
                    <td>{{$key->invitation->custom_field_2}}</td>
    				<td>{{$key->start_time}}</td>
    			</tr>
    		@endforeach
    	</tbody>
    </table>
</div>
@endsection
