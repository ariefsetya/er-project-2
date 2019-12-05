<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" style="height: 100% !important;">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{\App\EventDetail::where('event_id',Session::get('event_id'))->where('name','website_title')->first()->content}}</title>

    <!-- Styles -->
    <link rel="stylesheet" type="text/css" href="{{ url('css/bootstrap.min.css') }}">
</head>
<body style="position: relative;background-image: url({{\App\EventDetail::where('event_id',Session::get('event_id'))->where('name','website_background_image')->first()->content}});background-size: 100%;min-height: 100% !important;">
    <div id="app">
        <main class="py-4">

<div class="col-md-3 text-center" style="margin:0 auto;">
    <div class="">
      <img class="mb-4 text-center" src="{{\App\EventDetail::where('event_id',Session::get('event_id'))->where('name','website_header_logo')->first()->content}}" alt="" style="width: 100%;">
    </div>
</div>
            <img style="width:50%;position: absolute;top: 55%;left: 50%;transform: translate(-50%, -50%);" src="{{\App\EventDetail::where('event_id',Session::get('event_id'))->where('name','website_overlay_background')->first()->content}}"  id="img_overlay_home">
            @yield('content')
        </main>
    </div>
   
        
<div class="text-center col-md-3" style="margin:0 auto;">
      <img class="mb-4 text-center" src="{{\App\EventDetail::where('event_id',Session::get('event_id'))->where('name','website_footer_logo')->first()->content}}" alt="" style="width: 60%;">
</div>
</body>

<script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
@yield('footer')
</html>
