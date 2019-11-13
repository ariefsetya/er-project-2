@extends('layouts.guest')

@section('content')
<div class="col-md-3" style="margin:0 auto;">
    <div class="">
      <img class="mb-4 text-center" src="{{asset('img/HEADER.png')}}" alt="" style="width: 100%;">
    </div>
    <hr>
	@foreach($polling_answer as $key)
		<button onclick="selectdata('{{$polling_question[0]->id}}','{{$key->id}}')" class="btn btn-lg btn-primary btn-block"><h3>{{$key->content}}</h3></button>
	@endforeach
	<hr>
  <br>
</div>

<!-- Modal -->
<div class="modal fade" id="finishDialog" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body text-center">
      	{{$polling->finish_message}}
      </div>
      <div class="modal-footer">
        <a href="{{route('home')}}" class="btn btn-primary btn-block">OK</a>
      </div>
    </div>
  </div>
</div>

@endsection

@section('footer')
<script type="text/javascript" src="{{url('')}}:3000/socket.io/socket.io.js"></script>
<script type="text/javascript">
  var socket = io("{{url('')}}:3000");
	function selectdata(question_id, answer_id) {
		$.ajax({
		  	url: "{{route('select_quiz_response')}}/"+question_id+'/'+answer_id, 
		  	dataType:'json',
		  	method:'GET',
		  	success: function(result){
		  		$("#finishDialog").modal('show');
          if(result.win){
            socket.emit('quiz',result);
          }
			}
		});
	}
</script>
@endsection