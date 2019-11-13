{{csrf_field()}}
  <input type="hidden" name="event_id" value="1">
  <div class="form-group">
    <label for="polling_id">Polling</label>
    <select class="form-control" required name="polling_id" id="polling_id">
        @foreach($polling as $key)
            <option value="{{$key->id}}" {{($polling_question->polling_id ?? '')==$key->id?"selected":""}} >{{$key->name}}</option>
        @endforeach
    </select>
  </div>
  <div class="form-group">
    <label for="name">Pertanyaan</label>
    <input type="text" class="form-control" required name="content" id="content" placeholder="Pertanyaan" value="{{$polling_question->content ?? ''}}">
  </div>

  <div class="form-group">
    <label for="name">Pilihan Jawaban</label>
    <div id="answer_lists">
    @if(isset($polling_answer))
      @foreach($polling_answer as $key)
        <div class="input-group mb-3 answer_data">
          <input type="text" class="form-control" name="answer[]" placeholder="Jawaban" value="{{$key->content}}">
          <div class="input-group-append">
            <span class="input-group-text" onclick="adddata()"><i class="fa fa-plus"></i></span>
            @if(sizeof($polling_answer)>1)
            <span class="input-group-text" onclick="cleardata(this)"><i class="fa fa-minus"></i></span>
            @endif
          </div>
        </div>
      @endforeach
    @else
      <div class="input-group mb-3 answer_data">
        <input type="text" class="form-control" name="answer[]" placeholder="Jawaban" value="">
        <div class="input-group-append">
          <span class="input-group-text" onclick="adddata()"><i class="fa fa-plus"></i></span>
        </div>
      </div>
    @endif
    </div>
  </div>


  <button type="submit" class="btn btn-primary">Submit</button>

  <script type="text/javascript">
    function adddata() {
      // $("div.answer_data").clone().appendTo("#answer_lists");
      $("#answer_lists").append('<div class="input-group mb-3 answer_data"><input type="text" class="form-control" required name="answer[]" placeholder="Jawaban" value=""><div class="input-group-append"><span class="input-group-text" onclick="adddata()"><i class="fa fa-plus"></i></span><span class="input-group-text" onclick="cleardata(this)"><i class="fa fa-minus"></i></span></div></div>');
    }
    function cleardata(e) {
      $(e).parent().parent().remove();
    }
  </script>