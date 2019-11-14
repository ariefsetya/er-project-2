@extends('layouts.guest')

@section('content')

<div class="col-md-3" style="margin:0 auto;">
    <div class="">
      <img class="mb-4 text-center" src="{{asset('img/HEADER.png')}}" alt="" style="width: 100%;">
    </div>
    <h4>{{ $polling_question[0]->content }}</h4>
      @foreach($polling_answer as $key)
        <div class="form-check">
          <input style="width: 35px;height: 35px;" onclick="selectdata('{{$polling_question[0]->id}}', '{{$key->id}}')" type="radio" id="customRadio{{$key->id}}" name="customRadio{{$polling_question[0]->id}}" class="form-check-input input-lg">
          <label style="margin-left:10px;" onclick="selectdata('{{$polling_question[0]->id}}', '{{$key->id}}')" class="form-check-label form-control-lg" for="customRadio{{$key->id}}"><strong>{{$key->content}}</strong></label>
        </div>
      @endforeach
      <hr>
    {{$polling_question->render('vendor.pagination.quiz')}}
  <hr>
  <br>
</div>

@endsection

@section('footer')
<script type="text/javascript" src="http://localhost:3000/socket.io/socket.io.js"></script>
<script type="text/javascript">
  var winner = [];
  var socket = io("http://localhost:3000");
	function selectdata(question_id, answer_id) {
		$.ajax({
		  	url: "{{route('select_quiz_response')}}/"+question_id+'/'+answer_id, 
		  	dataType:'json',
		  	method:'GET',
		  	success: function(result){
          winner = result;
        }
		});
	}

  function finish_quiz() {
    if(winner.win){
      socket.emit('quiz',winner);
      window.location = '{{route('removeRedirectToHome')}}';
    }
  }

</script>
@endsection