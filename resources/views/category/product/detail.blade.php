@php
    $baseUrl=config('app.base_url');
@endphp

@extends('layouts.master')

@section('title')
    <title>Home | E-Shopper</title>
@endsection

@section('css')
    <link href="{{asset('home/home.css')}}" rel="stylesheet">
    <style>
        .style_comment{
            border:1px solid #ddd;
            border-radius:10px;
            background: #F0F0E9;
            color:#000;
            padding: 7px;
            margin-bottom: 10px;
        }
        .pro_detail{
            width: 100%;
        }
        .view-product{
            width: 41%;
        }
        #similar-product{
            width: 41%;
            margin-bottom: 15px;
        }
        .detail{
            position: absolute;
            top: 0;
            right: 0;
        }
        .tags_style{
            margin: 3px 2px;
            border: 1px solid;
            height: auto;
            background: #428bca;
            color: #fff;
            padding: 0px;
        }
        .tags_style:hover{
            background: black;
        }
    </style>
@endsection

@section('js')
    <script src="{{asset('home/home.js')}}"></script>
    <script>
        $(document).ready(function(){
            load_comment();
            view_Count();
            function view_Count(){
                var id=$('.product_id').val();
                var product_view=$('.product_views_'+id).val();
                var _token=$('input[name="_token"]').val();
                $.ajax({
                    url:'{{ url('/save-views') }}' ,
                    method:'POST',
                    data:{
                        id:id,
                        product_view:product_view,
                        _token:_token,
                    },
                    success:function(data){
                    },
                });
            }

            function load_comment(){
                var product_id=$('.product_comment_id').val();
                var _token=$('input[name="_token"]').val();
                $.ajax({
                    url:'{{ url('/load-comment') }}' ,
                    method:'POST',
                    data:{
                        product_id:product_id,
                        _token:_token,
                    },
                    success:function(data){
                        $('#comment_show').html(data);
                    },
                });
            };

            $('.send_comment').on('click',function(){
            var product_id=$('.product_comment_id').val();
            var comment_name=$('.comment_name').val();
            var comment_content=$('.comment_content').val();
            var _token=$('input[name="_token"]').val();
            $.ajax({
                url:'{{ url('/send-comment') }}' ,
                method:'POST',
                data:{
                    comment_name:comment_name,
                    product_id:product_id,
                    comment_content:comment_content,
                    _token:_token,
                },
                success:function(data){

                    $('.notify_comment').html('<span>Thêm bình luận thành công</span>');
                    load_comment();
                    $('.notify_comment').fadeOut(5000);
                    $('.comment_content').val('');
                },
            });
            });
        });
    </script>
@endsection

@section('content')

    <section>
        <div class="container">
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Trang chủ</a></li>
                <li class="breadcrumb-item"><a href="{{ route('category.product',['slug'=>$slugCategory, 'id'=>$idCategory]) }}">{{$nameCategory}}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{$proName}}</li>
              </ol>
            </nav>
            <div class="row">
                @include('components.sidebar')
                <div class="col-sm-9 padding-right">
                    @foreach($productDetail as $item)
                    <div class="product-details"><!--product-details-->

                            <div class="col-sm-5 pro_detail">
                                <div class="view-product">
                                    <img src="{{ $item->feature_image_path }}" alt="" />
                                    <h3>ZOOM</h3>
                                </div>
                                <div id="similar-product" class="carousel slide" data-ride="carousel">

                                    <!-- Wrapper for slides -->
                                    <div class="carousel-inner">
                                        @foreach($item->imageDetail as $key=>$imageDetail)
                                            @if($key % 3 ==0)
                                                <div class="item {{$key==0?'active':''}} list-detail">
                                                    @endif
                                                    <a href=""><img src="{{ $imageDetail->image_path }}" alt="" class="img-detail"></a>
                                                    @if($key % 3 == 2)
                                                </div>
                                            @endif
                                        @endforeach

                                    </div>

                                    <!-- Controls -->
                                    <a class="left item-control" href="#similar-product" data-slide="prev">
                                        <i class="fa fa-angle-left"></i>
                                    </a>
                                    <a class="right item-control" href="#similar-product" data-slide="next">
                                        <i class="fa fa-angle-right"></i>
                                    </a>
                                </div>

                            </div>
                            <div class="col-sm-7 detail">
                                <div class="product-information" style="padding-left: 44px;"><!--/product-information-->
                                    <img src="{{asset('eshopper/images/product-details/new.jpg')}}" class="newarrival" alt="" />
                                    <h2>{{$item->name}}</h2>
                                    <input type="hidden" name="product_comment_id" class="product_comment_id" value="{{ $item->id }}"/>
                                    <input type="hidden" name="product_id" class="product_id" value="{{ $item->id }}"/>
                                    <input type="hidden" name="product_views" class="product_views_{{ $item->id }}" value="{{ $item->views_count }}"/>
                                    <p>Product ID: {{$item->id}}</p>
                                    <img src="{{asset('eshopper/images/product-details/rating.png')}}" alt="" />
                                    <span>
									<span>{{number_format($item->price)}} VND</span>
									<span><input type="number" class="pro_qty" name="pro_qty" min="1" value="1" max="{{$item->product_quantity}}"></span>
									<a href=""
                                       data-url="{{ route('cart',['id'=>$item->id]) }}"
                                       class="btn btn-fefault cart add_cart">
										<i class="fa fa-shopping-cart"></i>
										Add to cart
									</a>
								</span>
                                    <p><b>Số lượng:</b> {{$item->product_quantity}}</p>
                                    <p><b>Loại sản phẩm:</b> {{$item->category->name}}</p>
                                    <p><b>Brand:</b> E-SHOPPER</p>
                                    <a href=""><img src="{{asset('eshopper/images/product-details/share.png')}}" class="share img-responsive"  alt="" /></a>
                                    <fieldset>
                                        <legend>Tags</legend>
                                        <p>
                                            <i class="fa fa-tag"></i>
                                            @foreach($item->tags as $tagItem)
                                                <a href="{{ url('/tag/'.$tagItem->name) }}" class="tags_style">{{$tagItem->name}}</a>
                                            @endforeach
                                        </p>

                                    </fieldset>
                                </div><!--/product-information-->
                            </div>

                    </div><!--/product-details-->

                    <div class="category-tab shop-details-tab"><!--category-tab-->
                        <div class="col-sm-12">
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#reviews" data-toggle="tab">Đánh giá</a></li>
                                <li><a href="#tag" data-toggle="tab">Thông tin sản phẩm </a></li>
                            </ul>
                        </div>
                        <div class="tab-content">

                            <div class="tab-pane fade in" id="tag" >
                                <div class="col-sm-12">
                                    {!! $item->content !!}
                                </div>
                            </div>
                            <div class="tab-pane fade active in" id="reviews" >
                                <div class="col-sm-12">
									<ul>
										<li><a href=""><i class="fa fa-user"></i>Admin</a></li>
										<li><a href=""><i class="fa fa-clock-o"></i>12:41 PM</a></li>
										<li><a href=""><i class="fa fa-calendar-o"></i>31 DEC 2014</a></li>
									</ul>
                                    <form action="">
                                        @csrf
                                        <div id="comment_show"></div>
                                    </form>


									<p><b>Viết đánh giá của bạn</b></p>

									<form action="#">
                                        @csrf
										<span>
                                            @php
                                                $session=Auth::check();
                                            @endphp
                                            @if($session)
                                                <input style="width:100%;margin:0;" type="hidden" placeholder="Tên người bình luận" class="comment_name" value="{{ Auth::user()->name }}"/>
                                            @else
                                                <input style="width:100%;margin:0;" type="text" placeholder="Tên bình luận" class="comment_name"/>
                                            @endif

										</span>
										<textarea name="comment" class="comment_content" placeholder="Nội dung bình luận" ></textarea>
										<b>Đánh giá sao: </b> <img src="images/product-details/rating.png" alt="" />
                                        <div class="notify_comment"></div>
										<button type="button" class="btn btn-default pull-right send_comment">
											Gửi bình luận
										</button>
									</form>
								</div>
							</div>
                        </div>
                    </div><!--/category-tab-->
                    @endforeach
                    <div class="recommended_items"><!--recommended_items-->
                        <h2 class="title text-center">recommended items</h2>

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
                                                            <a href="#"
                                                               data-url="{{ route('cart',['id'=>$item->id]) }}"
                                                               class="btn btn-default add-to-cart add_cart"><i class="fa fa-shopping-cart"></i>Add to cart</a>
                                                            <a href="{{ route('detail',['id'=>$item->id]) }}"
                                                               class="btn btn-default add-to-cart">
                                                                Detail
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









