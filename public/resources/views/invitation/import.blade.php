@extends('layouts.app')

@section('content')
<div class="">
    
    <h2>Import Data Tamu</h2>
    <form method="POST" enctype="multipart/form-data" action="{{route('invitation.process_import')}}">
    	{{csrf_field()}}

	  <div class="form-group">
	    <label for="import_type">Jenis Import</label>
	    <select type="text" class="form-control" required name="import_type" id="import_type" placeholder="Jenis Import">
	    	<option value="1">Import</option>
	    	<option value="2">Hapus &amp; Import</option>
	    </select>
	  </div>
	  <div class="form-group">
	    <label for="excel_file">File Excel</label>
	    <input type="file" class="form-control" required name="excel_file" id="excel_file" placeholder="File Excel">
	  </div>
  	<button type="submit" class="btn btn-primary">Submit</button>
    </form>

</div>
@endsection
