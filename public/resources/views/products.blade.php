@extends('layouts.guest')

@section('content')
<div class="col-md-4" style="margin:0 auto;">
    <div class="">
      <img class="mb-4 text-center" src="{{asset('img/HEADER.png')}}" alt="" style="width: 100%;">
    </div>
	@if(File::exists('img/products/'.$type.'/'.$code.'-1.png') and File::exists('img/products/'.$type.'/'.$code.'-2.png'))
  <div class="col-md-12">
    <img class="img-fluid" src="{{asset('img/products/'.$type.'/'.$code.'-1.png')}}">
  </div>
  <div class="col-md-12">
    <img class="img-fluid" src="{{asset('img/products/'.$type.'/'.$code.'-2.png')}}">
  </div>
  @else
  <div class="col-md-12">
    <img class="img-fluid" src="{{asset('img/products/'.$type.'/'.$code.'.png')}}">
  </div>
  @endif
  <hr>

  @if(!Session::has($code))
  <div id="vote" class="text-center">
  <h3>Do you like this product?</h3>
  <div class="text-center">
  <span class="btn btn-success btn-lg" onclick="selectresponse(1)">Yes</span>
  <span class="btn btn-danger btn-lg" onclick="selectresponse(0)">No</span>
  </div>
  </div>
  <hr>
  <br>
  @else
  <div id="vote" class="text-center">
  <h3>Thanks for your vote!</h3>
  </div>
  <hr>
  <br>
  @endif
</div>
@endsection

@section('footer')
	@if(!Session::has($code))
		<script type="text/javascript">

			function selectresponse(response_id) {
				$.ajax({
				  	url: "{{route('response_product')}}/"+'{{$code}}'+'/'+response_id, 
				  	dataType:'json',
				  	method:'GET',
				  	success: function(result){
				  		$("#vote").html('<h4>Thanks for your vote!</h4>');
					}
				});
			}
		</script>
	@endif
@endsection