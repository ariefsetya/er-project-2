@extends('layouts.app')

@section('content')
<div class="">
    <h2>Laporan Produk
    <a class="btn btn-primary float-right" href="{{route('product.export_excel')}}">Export</a></h2>
    <table class="table for_datatables">
    	<thead>
    		<tr>
	    		<th>Code</th>
	    		<th>Yes</th>
                <th>No</th>
                <th>Abstain</th>
                <th>Visitor</th>
                <th>Action</th>
	    	</tr>
    	</thead>
    	<tbody>
    		@foreach($summary as $key)
    			<tr>
    				<td>{{$key['code']}}</td>
                    <td>{{$key['yes']}}</td>
    				<td>{{$key['no']}}</td>
                    <td>{{$key['visit']-($key['yes']+$key['no'])}}</td>
                    <td>{{$key['visit']}}</td>
                    <td><a href="{{route('product.chart',[$key['id']])}}" class="btn btn-primary">Chart</a></td>
    			</tr>
    		@endforeach
    	</tbody>
    </table>
</div>
@endsection
