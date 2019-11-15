@extends('layouts.guest')

@section('content')
<div class="col-md-3" style="margin:0 auto;">
    <div class="">
      <img class="mb-4 text-center" src="{{asset('img/HEADER.png')}}" alt="" style="width: 100%;">
    </div>
    <hr>
    @for($i=0;$i<$polling->max_winner;$i++)
    <div id="winner_box_{{$i}}" class="text-center" style="display: none;">
      <h1>PEMENANG {{ $polling->max_winner>0?($i+1):'' }}</h1>
      <h2 id="name_{{$i}}"></h2>
      <h3 id="company_{{$i}}"></h3>
      <h5 id="created_at_{{$i}}"></h5>
    </div>
	 <hr>
   @endfor
  <br>
</div>


@endsection

@section('footer')
<script type="text/javascript" src="{{url('')}}/socket.io/socket.io.js"></script>
<script type="text/javascript">
  var socket = io("{{url('')}}");


  @for($i=0;$i<$polling->max_winner;$i++)
  var isi{{$i}} = false;
  @endfor
  var i = 0;
  socket.on('quiz',function(msg) {
      $("#name_"+i).html(msg.user.name);
      $("#company_"+i).html(msg.user.company);
      $("#created_at_"+i).html(msg.data.created_at);
      $("#winner_box_"+i).fadeIn();

      if(i=={{$polling->max_winner}}){
        $.ajax({
            url: "{{route('set_winner')}}/"+msg.data.id+'/'+msg.user.id, 
            dataType:'json',
            method:'GET',
            success: function(result){
              console.log(result);
            }
        });
      }
    i++;
  });

  
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
</script>
@endsection