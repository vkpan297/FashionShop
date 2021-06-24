@php
    $baseUrl=config('app.base_url');
@endphp

@extends('layouts.master')

@section('title')
    <title>Contact us</title>
@endsection

@section('css')
    <link href="{{asset('home/home.css')}}" rel="stylesheet">
@endsection

@section('js')
    <script src="{{asset('home/home.js')}}"></script>
@endsection

@section('content')

<div id="contact-page" class="container">
    <div class="bg">
        @foreach ($contact as $item)

        <div class="row">
            <div class="col-sm-12">
                <div class="contact-info">
                    <h2 class="title text-center">Thông tin liên hệ</h2>
                    <address>
                        <p>{!! $item->contact !!}</p>
                        {!! $item->fanpage !!}
                        </p>
                    </address>

                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <h2 class="title text-center">Liên Hệ <strong>Chúng Tôi</strong></h2>
                <div id="gmap" class="contact-map" style="position: relative; overflow:hidden;">
                    {!! $item->map !!}
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div><!--/#contact-page-->


@endsection

