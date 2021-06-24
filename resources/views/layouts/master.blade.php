<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
{{--    <meta name="description" content="{{$meta_decs}}">--}}
{{--    <meta name="author" content="">--}}
{{--    <meta name="keywords" content="{{$meta_keywords}}">--}}
{{--    <meta name="robots" content="INDEX,FOLLOW">--}}
    <link rel="canonical" href="{{$url_canonical}}" />
    <link rel="icon" type="image/x-icon" href="https://www.thol.com.vn/pub/media/favicon/stores/5/favicon.png" />
    @yield('meta')
    @yield('title')

    <link href="{{ asset('eshopper/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('eshopper/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('eshopper/css/prettyPhoto.css') }}" rel="stylesheet">
    <link href="{{ asset('eshopper/css/price-range.css') }}" rel="stylesheet">
    <link href="{{ asset('eshopper/css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('eshopper/css/main.css') }}" rel="stylesheet">
    <link href="{{ asset('home/header/header.css') }}" rel="stylesheet">
    @yield('css')
</head>
<body>
    @include('components.header')
    @yield('content')
    @include('components.footer')


<script src="{{ asset('eshopper/js/jquery.js') }}"></script>
<script src="{{ asset('eshopper/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('eshopper/js/jquery.scrollUp.min.js') }}"></script>
<script src="{{ asset('eshopper/js/price-range.js') }}"></script>
<script src="{{ asset('eshopper/js/jquery.prettyPhoto.js') }}"></script>
<script src="{{ asset('eshopper/js/main.js') }}"></script>
    <div id="fb-root"></div>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v10.0" nonce="EzWKn9bI"></script>
@yield('js')
</body>
</html>
