@extends('layouts.guest')

@section('content')
<div class="col-md-3" style="margin:0 auto;">
    <div class="">
      <img class="mb-4 text-center" src="{{asset('img/HEADER.png')}}" alt="" style="width: 100%;">
    </div>
    <hr>
    @for($i=0;$i<$polling->max_winner;$i++)
    <div id="winner_box_{{$i}}" class="text-center" style="display: none;">
      <h1>PEMENANG {{ $polling->max_winner>0?$i:'' }}</h1>
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
<script type="text/javascript" src="http://localhost:3000/socket.io/socket.io.js"></script>
<script type="text/javascript">
  var socket = io("http://localhost:3000");

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
</script>
@endsection