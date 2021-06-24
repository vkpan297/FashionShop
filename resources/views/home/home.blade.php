@php
    $baseUrl=config('app.base_url');
@endphp

@extends('layouts.master')

@section('title')
    <title>{{$meta_title}}</title>
@endsection

@section('css')
    <link href="{{asset('home/home.css')}}" rel="stylesheet">
    <style>

    </style>
@endsection

@section('js')
    <script src="{{asset('home/home.js')}}"></script>
@endsection

@section('content')

    <!--slider-->
    @include('home.components.slider')
    <!--/slider-->

    <div class="container">
            <div class="row">
                @include('components.sidebar')
                <div class="col-sm-9 padding-right">
                    <div class="features_items"><!--features_items-->
                        <h2 class="title text-center">Sản phẩm nổi bật</h2>
                        @foreach($products as $productsItem)
                            <div class="col-sm-4">
                            <div class="product-image-wrapper">
                                <div class="single-products">
                                    <div class="productinfo text-center">
                                        <img src="{{ $productsItem->feature_image_path}}" alt="" id="img_path{{ $productsItem->id }}" class="img_path"/>
                                        <h2>{{ number_format($productsItem->price) }} VND</h2>
                                        <p>{{ $productsItem->name }}</p>
                                        <input type="hidden" name="product_id" class="product_id" value="{{ $productsItem->id }}"/>
                                        <input type="hidden" name="product_views" class="product_views_{{ $productsItem->id }}" value="{{ $productsItem->views_count }}"/>
                                        <input type="hidden" class="max_qty" name="max_qty" value="{{$productsItem->product_quantity}}">
                                        <input type="hidden" class="pro_qty" name="pro_qty" min="1" value="1">
                                        <input type="hidden" id="pro_price{{ $productsItem->id }}" value="{{ number_format($productsItem->price) }} VND">
                                        <input type="hidden" id="pro_name{{ $productsItem->id }}" value="{{ $productsItem->name }}">
                                        <a href="#"
                                           data-url="{{ route('cart',['id'=>$productsItem->id]) }}"
                                           class="btn btn-default add-to-cart add_cart">
                                            Thêm giỏ hàng
                                        </a>
                                        <a id="pro_url{{ $productsItem->id }}" href="{{ route('detail',['id'=>$productsItem->id]) }}"
                                            class="btn btn-default add-to-cart btn-detail">
                                             Mô tả
                                         </a>
                                    </div>
                                </div>
                                <div class="choose">
                                    <ul class="nav nav-pills nav-justified">
                                        <li>
                                            <button class="button_wishlist" id="{{ $productsItem->id }}" onclick="add_wishlist(this.id);">
                                                <i class="fa fa-plus-square" style="margin-right: 5px;"></i>
                                                Yêu thích
                                            </button>
                                        </li>
                                        <li><a href="#"><i class="fa fa-plus-square"></i>So sánh</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div><!--features_items-->

                    <div class="category-tab"><!--category-tab-->
                        <div class="col-sm-12">
                            <ul class="nav nav-tabs">
                                @foreach($categories as $key=>$categoriesItemParent)
                                <li class="{{$key == 0 ? 'active':''}}">
                                    <a href="#category_tab_{{$categoriesItemParent->id}}" data-toggle="tab">
                                        {{$categoriesItemParent->name}}
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        </div>


                        <div class="tab-content">
                            @foreach($categories as $keyProduct=>$categoriesItemProduct)
                            <div class="tab-pane fade {{$keyProduct == 0 ? 'active in' : ''}}" id="category_tab_{{$categoriesItemProduct->id}}" >
                                @foreach($categoriesItemProduct->products as $productItemTab)
                                <div class="col-sm-3">
                                    <div class="product-image-wrapper" style="width: 235px;">
                                        <div class="single-products">
                                            <div class="productinfo text-center">
                                                <img src="{{$productItemTab->feature_image_path}}" alt="" class="img_path"/>
                                                <h2>{{number_format($productItemTab->price)}} VND</h2>
                                                <p>{{$productItemTab->name}}</p>
                                                <input type="hidden" class="max_qty" name="max_qty" value="{{$productsItem->product_quantity}}">
                                                <input type="hidden" class="pro_qty" name="pro_qty" min="1" value="1">
                                                <a href="#"
                                                   data-url="{{ route('cart',['id'=>$productItemTab->id]) }}"
                                                   class="btn btn-default add-to-cart add_cart"><i class="fa fa-shopping-cart"></i>Thêm giỏ hàng</a>
                                                <a href="{{ route('detail',['id'=>$productItemTab->id]) }}"
                                                   class="btn btn-default add-to-cart">
                                                   Mô tả
                                                </a>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            @endforeach
                        </div>
                    </div><!--/category-tab-->

                    <div class="recommended_items"><!--recommended_items-->
                        <h2 class="title text-center">Sản phẩm được xem nhiều nhất</h2>

                        <div id="recommended-item-carousel" class="carousel slide" data-ride="carousel">
                            <div class="carousel-inner">
                                @foreach($productRecommend as $keyRecommend=>$item)
                                    @if($keyRecommend % 3 ==0)
                                        <div class="item {{$keyRecommend==0?'active':''}}">
                                            @endif
                                            <div class="col-sm-4">
                                                <div class="product-image-wrapper">
                                                    <div class="single-products">
                                                        <div class="productinfo text-center">
                                                            <img src="{{$item->feature_image_path}}" alt="" class="img_path"/>
                                                            <h2>{{number_format($item->price)}}</h2>
                                                            <p>{{$item->name}}</p>
                                                            <input type="hidden" class="max_qty" name="max_qty" value="{{$item->product_quantity}}">
                                                            <input type="hidden" class="pro_qty" name="pro_qty" min="1" value="1">
                                                            <a href="#"
                                                               data-url="{{ route('cart',['id'=>$item->id]) }}"
                                                               class="btn btn-default add-to-cart add_cart"><i class="fa fa-shopping-cart"></i>Thêm giỏ hàng</a>
                                                            <a href="{{ route('detail',['id'=>$item->id]) }}"
                                                               class="btn btn-default add-to-cart">
                                                                Mô tả
                                                            </a>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                            @if($keyRecommend % 3 == 2)
                                        </div>
                                    @endif
                                @endforeach





                            </div>
                            <a class="left recommended-item-control" href="#recommended-item-carousel" data-slide="prev">
                                <i class="fa fa-angle-left"></i>
                            </a>
                            <a class="right recommended-item-control" href="#recommended-item-carousel" data-slide="next">
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </div>
                    </div><!--/recommended_items-->

                </div>
            </div>
        </div>
    </section>


@endsection

