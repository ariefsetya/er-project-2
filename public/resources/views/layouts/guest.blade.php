<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" style="height: 100% !important;">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>AQUA JAPAN | 2019 ANNUAL DEALERS GATHERING</title>

    <!-- Styles -->
    <link rel="stylesheet" type="text/css" href="{{ url('css/bootstrap.min.css') }}">
</head>
<body style="position: relative;background-image: url({{ asset('img/BACKGROUND.png') }});background-size: 100%;min-height: 100% !important;">
    <div id="app">
        <main class="py-4">
            @yield('content')
        </main>
    </div>
   
        <div class="col-md-3 footer" style="z-index:-999999999;margin:0 auto 20px;padding: 0;position: absolute;bottom:0;left:0;right:0;">
          <img class="text-center" src="{{ asset('img/FOOTER.png') }}" alt="" style="width: 90%;margin: 0 0 0 5%;left:50%;">
        </div>
</body>

<script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
@yield('footer')
<script type="text/javascript">
    /*
    $(document).ready(function() {
    var _originalSize = $(window).width() + $(window).height()
    $(window).resize(function() {
        if ($(window).width() + $(window).height() != _originalSize) {
            console.log("keyboard active");
            $(".footer").removeClass("fixed");
        } else {
            console.log("keyboard closed");
            $(".footer").addClass("fixed");
        }
    });
});
*/
</script>
</html>
