@extends('layouts.guest')

@section('content')
<div class="col-md-3" style="margin:0 auto;">
    <div class="">
      <img class="mb-4 text-center" src="{{asset('img/HEADER.png')}}" alt="" style="width: 100%;">
    </div>
    <hr>
    <div id="winner_box" style="display: none;">
      <h1>PEMENANG</h1>
      <h2 id="name"></h2>
      <h3 id="company"></h3>
      <h5 id="answer_text"></h5>
      <h5 id="created_at"></h5>
    </div>
	<hr>
  <br>
</div>


@endsection

@section('footer')
<script type="text/javascript" src="{{url('')}}:3000/socket.io/socket.io.js"></script>
<script type="text/javascript">
  var socket = io("{{url('')}}:3000");
  var isi = false;
  socket.on('quiz',function(msg) {
    if(!isi){
      isi = true;  
      $("#name").html(msg.user.name);
      $("#company").html(msg.user.company);
      $("#answer_text").html(msg.data.answer_text);
      $("#created_at").html(msg.data.created_at);
      $("#winner_box").fadeIn();

      $.ajax({
          url: "{{route('set_winner')}}/"+msg.data.id+'/'+msg.user.id, 
          dataType:'json',
          method:'GET',
          success: function(result){

        }
      });
    }
  });
</script>
@endsection