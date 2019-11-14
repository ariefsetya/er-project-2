@extends('layouts.guest')

@section('content')

<div class="col-md-3" style="margin:0 auto;">
    <div class="">
      <img class="mb-4 text-center" src="{{asset('img/HEADER.png')}}" alt="" style="width: 100%;">
    </div>
  <form method="POST" action="{{route('join_quiz',[$polling->id])}}">

    {{csrf_field()}}
    <div class="form-group text-center">
      <label for="name" class="form-control-lg">Nama</label>
      <input type="text" class="form-control form-control-lg" id="name" name="name" value="{{ old('name') }}">
      @if($errors->any())
        @foreach ($errors->get('name') as $message)
        <div class="invalid-feedback">
          {{$message}}
        </div>
        @endforeach
      @endif
    </div>
    <div class="form-group text-center">
      <label for="company" class="form-control-lg">Nama Dealer</label>
      <input type="text" class="form-control form-control-lg" id="company" name="company" value="{{ old('company') }}">
      @if($errors->any())
        @foreach ($errors->get('company') as $message)
        <div class="invalid-feedback">
          {{$message}}
        </div>
        @endforeach
      @endif
    </div>
    <button type="submit" class="btn btn-primary btn-block btn-lg">Mulai {{$polling->name}}</button>
    <br>
  </form>
</div>
<style type="text/css">
  .invalid-feedback{
    display: block !important;
  }
</style>
@endsection
