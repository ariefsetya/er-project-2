@extends('layouts.guest')

@section('content')
<div id="lader"></div>
<style type="text/css">
  /* Center the loader */
  #loader {
    position: absolute;
    left: 50%;
    top: 50%;
    z-index: 1;
    width: 150px;
    height: 150px;
    margin: -75px 0 0 -75px;
    border: 16px solid #f3f3f3;
    border-radius: 50%;
    border-top: 16px solid #3498db;
    width: 120px;
    height: 120px;
    -webkit-animation: spin 2s linear infinite;
    animation: spin 2s linear infinite;
  }

  @-webkit-keyframes spin {
    0% { -webkit-transform: rotate(0deg); }
    100% { -webkit-transform: rotate(360deg); }
  }

  @keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
  }

  /* Add animation to "page content" */
  .animate-bottom {
    position: relative;
    -webkit-animation-name: animatebottom;
    -webkit-animation-duration: 1s;
    animation-name: animatebottom;
    animation-duration: 1s
  }

  @-webkit-keyframes animatebottom {
    from { bottom:-100px; opacity:0 } 
    to { bottom:0px; opacity:1 }
  }

  @keyframes animatebottom { 
    from{ bottom:-100px; opacity:0 } 
    to{ bottom:0; opacity:1 }
  }

  #myDiv {
    display: none;
    text-align: center;
  }
</style>

<div class="col-md-4 animate-bottom" id="myDiv" style="margin:0 auto;display: none;">
    <div class="">
      <img class="mb-4 text-center lazy" data-src="{{asset('img/HEADER.png')}}" alt="" style="width: 100%;">
    </div>
	@if(File::exists('img/PRODUCTS/'.$type.'/'.$code.'/'.$code.'.png') and File::exists('img/PRODUCTS/'.$type.'/'.$code.'/FEATURES.png'))
  <div class="col-md-12">
    <img class="lazy img-fluid" data-src="{{asset('img/PRODUCTS/'.$type.'/'.$code.'/'.$code.'.png')}}">
  </div>
  <div class="col-md-12">
    <img class="lazy img-fluid" data-src="{{asset('img/PRODUCTS/'.$type.'/'.$code.'/FEATURES.png')}}">
  </div>
  @elseif(File::exists('img/PRODUCTS/'.$type.'/'.$code.'/'.$code.'-1.png') and File::exists('img/PRODUCTS/'.$type.'/'.$code.'/'.$code.'-2.png'))
  <div class="col-md-12">
    <img class="lazy img-fluid" data-src="{{asset('img/PRODUCTS/'.$type.'/'.$code.'/'.$code.'-1.png')}}">
  </div>
  <div class="col-md-12">
    <img class="lazy img-fluid" data-src="{{asset('img/PRODUCTS/'.$type.'/'.$code.'/'.$code.'-2.png')}}">
  </div>
  @else
  <div class="col-md-12">
    <img class="lazy img-fluid" data-src="{{asset('img/PRODUCTS/'.$type.'/'.$code.'/'.$code.'.png')}}">
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
  <script src="{{ asset('js/lazyload.min.js') }}"></script>
  <script type="text/javascript">
      $(window).on('load',function() {
        // $("#loader").fadeOut();
        // $("#myDiv").fadeIn();
      });


      
      (function() {
        function logElementEvent(eventName, element) {
          console.log(
            Date.now(),
            eventName,
            element.getAttribute("data-src")
          );
        }

        var callback_enter = function(element) {
          logElementEvent("🔑 ENTERED", element);
        };
        var callback_exit = function(element) {
          logElementEvent("🚪 EXITED", element);
        };
        var callback_reveal = function(element) {
          logElementEvent("👁️ REVEALED", element);
        };
        var callback_loaded = function(element) {
          logElementEvent("👍 LOADED", element);
        };
        var callback_error = function(element) {
          logElementEvent("💀 ERROR", element);
          element.src =
            "https://via.placeholder.com/440x560/?text=Error+Placeholder";
        };
        var callback_finish = function() {
          logElementEvent("✔️ FINISHED", document.documentElement);
        };

        var ll = new LazyLoad({
          elements_selector: ".lazy",
          // Assign the callbacks defined above
          callback_enter: callback_enter,
          callback_exit: callback_exit,
          callback_reveal: callback_reveal,
          callback_loaded: callback_loaded,
          callback_error: callback_error,
          callback_finish: callback_finish
        });
      })();
  </script>
@endsection