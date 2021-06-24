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
            <div class="row">
                @include('components.sidebar')

                <div class="col-sm-9 padding-right">
                    <div class="features_items"><!--features_items-->
                        <h2 class="title text-center">Search Items</h2>
                        @foreach($productSearch as $product)
                            <div class="col-sm-4">
                                <div class="product-image-wrapper">
                                    <div class="single-products">
                                        <div class="productinfo text-center">
                                            <img src="{{$product->feature_image_path}}" alt="" class="img_path"/>
                                            <h2>{{number_format($product->price)}} VND</h2>
                                            <p>{{$product->name}}</p>
                                            <input type="hidden" class="max_qty" name="max_qty" value="{{$product->product_quantity}}">
                                            <input type="hidden" class="pro_qty" name="pro_qty" min="1" value="1">
                                            <a href="" class="btn btn-default add-to-cart add_cart"><i class="fa fa-shopping-cart"></i>Add to cart</a>
                                        </div>
                                        <div class="product-overlay">
                                            <div class="overlay-content">
                                                <h2>{{number_format($product->price)}} VND</h2>
                                                <p>{{$product->name}}</p>
                                                <input type="hidden" class="max_qty" name="max_qty" value="{{$product->product_quantity}}">
                                                <input type="hidden" class="pro_qty" name="pro_qty" min="1" value="1">
                                                <a href=""
                                                   data-url="{{ route('cart',['id'=>$product->id]) }}"
                                                   class="btn btn-default add-to-cart add_cart"><i class="fa fa-shopping-cart"></i>Add to cart</a>
                                                <a href="{{ route('detail',['id'=>$product->id]) }}"
                                                   class="btn btn-default add-to-cart">
                                                    Detail
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="choose">
                                        <ul class="nav nav-pills nav-justified">
                                            <li><a href=""><i class="fa fa-plus-square"></i>Add to wishlist</a></li>
                                            <li><a href=""><i class="fa fa-plus-square"></i>Add to compare</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div><!--features_items-->
                </div>
            </div>
        </div>
    </section>
@endsection
