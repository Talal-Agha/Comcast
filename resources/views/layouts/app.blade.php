<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
  <title>Xfinity</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="keywords" content="">
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
 <link href="{{ asset('/css/main.css') }}" rel="stylesheet">
 
  <style>
    /* Remove the navbar's default margin-bottom and rounded borders */ 
    .navbar {
      margin-bottom: 0;
      border-radius: 0;
    }
    
    /* Add a gray background color and some padding to the footer */
    footer {
      padding: 25px;
    }
  </style>
  @yield('css')
</head>

<body>
    <div id="app">
        @include('partials.header')
        @include('partials.nav')
        <div class="text-center">
            @include('flash::message')
        </div>
        @yield('content')
        @include('partials.footer')
        <div id="simplemodal-video" class="simplemodal" style="display:none;">
            <iframe src="" width="800" height="450" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen scrolling="no"></iframe>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/jquery.cycle.js') }}"></script>
    <script src="{{ asset('js/js/current.js') }}"></script>
    <script src="{{ asset('js/js/callout.min.js') }}"></script>
    <script src="{{ asset('js/js/simplemodal.js') }}"></script>
    <script src="{{ asset('js/js/common.min.js') }}"></script>
    <script type="text/javascript">
        $('div.alert').not('.alert-important').delay(3000).fadeOut(350);
        // <![CDATA[
        hbspt.cta.load(454248, '7aa2d264-8054-455c-8392-79175b384ac6');
        // ]]>
    </script>
    @yield('footer_js')
</body>
</html>
