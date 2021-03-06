
@extends('layouts.guest')

@section('content')
<div class="text-center col-md-3" style="margin:0 auto;">
    @if(\App\EventDetail::where('event_id',Session::get('event_id'))->where('name','mode')->first()->content=='register_barcode')


        @if($message = Session::get('success'))
        <p class="text-center" style="color:white;">{{\App\EventDetail::where('event_id',Session::get('event_id'))->where('name','barcode_email_sent_message')->first()->content}}</p>
        @endif

    @elseif(in_array(\App\EventDetail::where('event_id',Session::get('event_id'))->where('name','mode')->first()->content,['polling_website','register_face']))
        <h3>{{\App\EventDetail::where('event_id',Session::get('event_id'))->where('name','greeting_text')->first()->content}}
        @if(Auth::check())
        <br>
        {{Auth::user()->name}}<br>
        {{Auth::user()->company}}
        @endif
        </h3>
    @endif

    @if(\App\EventDetail::where('event_id',Session::get('event_id'))->where('name','mode')->first()->content=='register_face')
        @if(Auth::check())
            @if(Auth::user()->custom_field_3=='')
                <a class="btn btn-lg btn-primary text-white col-md-12" href="{{route('invitation.register_face')}}">SELANJUTNYA</a>
            @endif
        @endif
    @endif

    @if(\App\EventDetail::where('event_id',Session::get('event_id'))->where('name','idle')->first()->content==0)
        @foreach(\App\Polling::where('event_id',Session::get('event_id'))->get() as $row)
        	@if($row->polling_type_id==3)
            	@if(Auth::check())
                    @if(\App\PollingResponse::where('event_id',Session::get('event_id'))->where('invitation_id',Auth::user()->id)->count()==\App\PollingQuestion::where('event_id',Session::get('event_id'))->where('polling_id',$row->id)->count())
                        <a class="btn btn-lg btn-secondary text-white col-md-12">{{$row->name}}</a>
                    @else
                        <a href="{{route('quiz_response',[$row->id])}}" class="btn btn-lg btn-dark col-md-12">{{$row->name}}</a>
                    @endif
            	@else
                    <a href="{{route('quiz_join',[$row->id])}}" class="btn btn-lg btn-dark col-md-12">{{$row->name}}</a>
                @endif
            @else
                @if(\Session::has('polling_'.$row->id))
                    <a class="btn btn-lg btn-secondary text-white col-md-12">{{$row->name}}</a>
                @else
                    <a href="{{route('polling_response',[$row->id])}}" class="btn btn-lg btn-dark col-md-12">{{$row->name}}</a>
                @endif
            @endif
            <hr>
        @endforeach
    @else
    <h2>Please scan again later</h2>
    @endif


    @if(\App\EventDetail::where('event_id',Session::get('event_id'))->where('name','mode')->first()->content=='register_barcode')
        @if(!Auth::check())
            <div style="display: block;" id="overlay_home"></div>
            <a id="button_register" style="display:none;background: yellow; color: black;" href="{{route('registerPage')}}" class="btn btn-lg col-md-12">REGISTER</a>
        @else
            <div style="width:100%; margin:0 auto;position: relative;display: block;clear: both;">
                <h5 style="color:white">{{\App\EventDetail::where('event_id',Session::get('event_id'))->where('name','barcode_success_message')->first()->content}}</h5>
                <br>
                <div style="width:50%; margin:0 auto;">
                    <div style="background: white;padding:20px;">
                        <img style="width: 100%" src="{{\App\EventDetail::where('event_id',Session::get('event_id'))->where('name','barcode_url')->first()->content.Auth::user()->reg_number}}">
                    </div>
                </div>
                <br>
                <div style="display: block;color: white;width:70%;margin:0 auto;">Please save and scan the QR Code<br>at registration desk on venue</div>
                <br>
                <div style="display: block;">
                        <a class="btn btn-block btn-lg" href="{{route('downloadBarcode')}}" style="background: yellow;">DOWNLOAD QR CODE</a>
                        <a class="btn btn-block btn-lg" href="{{route('sendEmailBarcode')}}" style="background: yellow;">SEND QR CODE TO MY EMAIL</a>
                </div>
            </div>
        @endif
    @endif

    @if(\App\EventDetail::where('event_id',Session::get('event_id'))->where('name','logout_button_visibility')->first()->content==1)
        @if(Auth::check())
            <br>
            <br>
            <a href="{{route('logout')}}" class="btn btn-lg btn-dark col-md-12">Logout</a>
        @endif
    @endif
</div>
@endsection

@section('footer')
    @if(\App\EventDetail::where('event_id',Session::get('event_id'))->where('name','mode')->first()->content=='register_barcode')
        @if(!Auth::check())
        <script type="text/javascript">
            $(window).ready(function() {
                $("#overlay_home").css('height',$("#img_overlay_home").height()+40);
                $("#button_register").fadeIn();
            });
        </script>
        @endif
    @endif
    
@endsection