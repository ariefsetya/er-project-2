@extends('layouts.app')

@section('content')
<div class="">
    <h2>Laporan Produk
    <a class="btn btn-primary float-right" href="{{route('product.export_excel')}}">Export</a></h2>
    <table class="table for_datatables">
    	<thead>
    		<tr>
	    		<th>Kode</th>
	    		<th>Suka</th>
                <th>Tidak Suka</th>
                <th>Kunjungan</th>
	    	</tr>
    	</thead>
    	<tbody>
    		@foreach($summary as $key)
    			<tr>
    				<td>{{$key['code']}}</td>
                    <td>{{$key['yes']}}</td>
    				<td>{{$key['no']}}</td>
                    <td>{{$key['visit']}}</td>
    			</tr>
    		@endforeach
    	</tbody>
    </table>
</div>
@endsection
