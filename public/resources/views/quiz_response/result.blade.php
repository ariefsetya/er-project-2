@extends('layouts.guest')

@section('content')
<div class="col-md-3" style="margin:0 auto;">
    <div class="">
      <img class="mb-4 text-center" src="{{asset('img/HEADER.png')}}" alt="" style="width: 100%;">
    </div>
    <hr>
    <h1 class="text-center">Pemenang {{$polling->name}}</h1>
    @for($i=0;$i<$polling->max_winner;$i++)
    <div id="winner_box_{{$i}}" class="text-center" style="display: none;">
      <h2>Pemenang {{ $polling->max_winner>0?($i+1):'' }}</h2>
      <h3 id="name_{{$i}}"></h3>
      <h3 id="company_{{$i}}"></h3>
      <h5 id="created_at_{{$i}}"></h5>
    </div>
	 <hr>
   @endfor
  <br>
</div>


@endsection

@section('footer')
<script type="text/javascript" src="http://localhost:3000/socket.io/socket.io.js"></script>
<script type="text/javascript">
  var socket = io("http://localhost:3000");
  get_winner();
  socket.on('quiz',function(msg) {
      get_winner();
  });
  socket.on('screen.change',function(msg) {
    $("body").fadeOut(500);
    setTimeout(function () {
      window.location = msg
    },500);
  });

  function get_winner(argument) {
    $.ajax({
        url: "{{route('quiz_result_data',[$polling->id])}}", 
        dataType:'json',
        method:'GET',
        success: function(result){
          var participant = result.polling_participant;
          for (var x = 0; x < participant.length; x++) {
            $("#name_"+x).html(participant[x].invitation.name);
            $("#company_"+x).html(participant[x].invitation.company);
            $("#created_at_"+x).html(participant[x].created_at);
            $("#winner_box_"+x).fadeIn();
          }
      }
    });
  }
</script>
@endsection