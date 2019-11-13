@extends('layouts.guest')

@section('content')
<div class="text-center  col-md-3" style="margin:0 auto;">
    <form class="form-signin" method="post" action="{{route('phoneLogin')}}">
      {{csrf_field()}}

    <div class="">
      <img class="mb-4 text-center" src="{{asset('img/HEADER.png')}}" alt="" style="width: 100%;">
    </div>
      
    @if (\Session::has('message'))
        <div class="alert alert-danger">
          {!! \Session::get('message') !!}
        </div>
    @endif
    <input type="hidden" name="country_id" value="100">
    <div class="input-group mb-3 input-group-large">
  <div class="input-group-prepend">
    <span class="input-group-text" id="inputGroup-sizing-lg">+62</span>
  </div>
      <input type="number" name="phone" id="phone" class="form-control form-control-lg" placeholder="Phone Number" aria-label="Recipient's username" aria-describedby="basic-addon2">
    </div>

      <button class="btn btn-lg btn-primary btn-block" type="submit">Check In</button>
    </form>
</div>
@endsection
