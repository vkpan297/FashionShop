@php
    $baseUrl=config('app.base_url');
@endphp

@extends('layouts.master')

@section('title')
    <title>Home | E-Shopper</title>
@endsection

@section('css')
    <link href="{{asset('home/home.css')}}" rel="stylesheet">
@endsection

@section('js')
    <script src="{{asset('home/home.js')}}"></script>
@endsection

@section('content')
    <section id="advertisement">
        <div class="container">
            <img src="{{asset('eshopper/images/shop/advertisement.jpg')}}" alt="" />
        </div>
    </section>

    <section>
        <div class="container">
        <nav aria-label="breadcrumb">
                      <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">Trang chủ</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{$nameCategory}}</li>
                      </ol>
                    </nav>
            <div class="row">
                @include('components.sidebar')

                <div class="col-sm-9 padding-right">
                    <div class="features_items"><!--features_items-->


                        <h2 class="title text-center">Features Items</h2>
                        @foreach($products as $product)
                        <div class="col-sm-4">
                            <div class="product-image-wrapper">
                                <div class="single-products">
                                    <div class="productinfo text-center">
                                        <img src="{{ $product->feature_image_path}}" alt="" id="img_path{{ $product->id }}" class="img_path"/>
                                        <h2>{{ number_format($product->price) }} VND</h2>
                                        <p>{{ $product->name }}</p>
                                        <input type="hidden" class="max_qty" name="max_qty" value="{{$product->product_quantity}}">
                                        <input type="hidden" class="pro_qty" name="pro_qty" min="1" value="1">
                                        <input type="hidden" id="pro_price{{ $product->id }}" value="{{ number_format($product->price) }} VND">
                                        <input type="hidden" id="pro_name{{ $product->id }}" value="{{ $product->name }}">
                                        <a href="#"
                                           data-url="{{ route('cart',['id'=>$product->id]) }}"
                                           class="btn btn-default add-to-cart add_cart">
                                            Thêm giỏ hàng
                                        </a>
                                        <a id="pro_url{{ $product->id }}" href="{{ route('detail',['id'=>$product->id]) }}"
                                            class="btn btn-default add-to-cart">
                                             Chi tiết
                                         </a>
                                    </div>

                                </div>
                                <div class="choose">
                                    <ul class="nav nav-pills nav-justified" style="flex-wrap: wrap;display: flex;">
                                        <li style="width: 49%; align-items: center; display: flex;">
                                            <button class="button_wishlist" id="{{ $product->id }}" onclick="add_wishlist(this.id);">
                                                <i class="fa fa-plus-square" style="margin-right: 5px;"></i>
                                                Yêu thích
                                            </button>
                                        </li>
                                        <li style="width: 50%;"><a href=""><i class="fa fa-plus-square"></i>So sánh</a></li>
                                        <li style="display: flex;"><div class="fb-share-button" data-href="{{$url_canonical}}" data-layout="button_count" data-size="small"><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u={{$url_canonical}}&amp;src=sdkpreparse" class="fb-xfbml-parse-ignore">Chia sẻ</a></div>
                                            <div class="fb-like" data-href="{{$url_canonical}}" data-width="" data-layout="button_count" data-action="like" data-size="small" data-share="false"></div></li>
                                    </ul>

                                </div>
                            </div>
                        </div>
                        @endforeach
                        {{ $products->links() }}

                    </div><!--features_items-->
                    <div class="fb-comments" data-href="{{$url_canonical}}" data-width="" data-numposts="20"></div>

                </div>
            </div>
        </div>
    </section>

@endsection









