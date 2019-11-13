{{csrf_field()}}
  <input type="hidden" name="event_id" value="1">
  <div class="form-group">
    <label for="name">Nama</label>
    <input type="text" class="form-control" required name="name" id="name" placeholder="Nama" value="{{$event_detail->name ?? ''}}">
  </div>
  <div class="form-group">
    <label for="content">Isi</label>
    <input type="text" class="form-control" required name="content" id="content" placeholder="Isi" value="{{$event_detail->content ?? ''}}">
  </div>

  <button type="submit" class="btn btn-primary">Submit</button>