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
    <style type="text/css">
        @page { margin: 0px !important; }
        body { margin: 0px !important; }
    </style>
</head>
<body style="position: relative;background-image: url({{\App\EventDetail::where('event_id',Session::get('event_id'))->where('name','website_background_image')->first()->content}});background-size: 100%;min-height: 100% !important;">
    <div id="app">
        <main class="py-4">

<div class="text-center" style="margin:0 auto;">

            <div style="width:90%; margin:0 auto;position: relative;display: block;clear: both;">
                <br>

      <img class="mb-4 text-center" src="{{\App\EventDetail::where('event_id',Session::get('event_id'))->where('name','website_header_logo')->first()->content}}" alt="" style="width: 100%;">
                <br>
                <br>
                <h2 style="color:white;margin:0 auto;text-align: center;">REGISTRATION SUCCESS!</h2>
                <br>
                <br>
                <br>
                <div style="width:50%; margin:0 auto;">
                    <div style="background: white;padding:20px;">
                        <img style="width: 100%" src="{{\App\EventDetail::where('event_id',Session::get('event_id'))->where('name','barcode_url')->first()->content.Auth::user()->reg_number}}">
                    </div>
                </div>
                <br>
                <br>
                <div style="display: block;color: white;text-align:center;width:70%;margin:0 auto;font-size:16pt;">Please save and scan the QR Code<br>at registration desk on venue</div>
            </div>
</div>

</main>
    </div>
   
        
<div class="text-center col-md-3" style="margin:0 auto;">
      <img class="mb-4 text-center" src="{{\App\EventDetail::where('event_id',Session::get('event_id'))->where('name','website_footer_logo')->first()->content}}" alt="" style="width: 60%;">
</div>
</body>
</html>
