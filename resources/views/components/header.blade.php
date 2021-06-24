
<style>
    .nav .open>a, .nav .open>a:hover, .nav .open>a:focus {
        background-color: unset !important;
        border-color: #428bca;
    }
</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"></script>
<script>
    function Ktcart(){
        alert("Giỏ hàng của bạn đang trống ! Hãy thêm sản phẩm vào giỏ hàng")
    }
</script>
<header id="header"><!--header-->
    <div class="header_top"><!--header_top-->
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <div class="contactinfo">
                        <ul class="nav nav-pills">
                            <li><a href="#"><i class="fa fa-phone"></i>{{ getConfigValue('phone_contact') }}</a></li>
                            <li><a href="#"><i class="fa fa-envelope"></i>{{ getConfigValue('email') }}</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="social-icons pull-right">
                        <ul class="nav navbar-nav">
                            <li><a href="{{ getConfigValue('facebook_link') }}"><i class="fa fa-facebook"></i></a></li>
                            <li><a href="{{ getConfigValue('twitter_link') }}"><i class="fa fa-twitter"></i></a></li>
                            <li><a href="{{ getConfigValue('linkendin_link') }}"><i class="fa fa-linkedin"></i></a></li>
                            <li><a href="{{ getConfigValue('youtube_link') }}"><i class="fa fa-dribbble"></i></a></li>
                            <li><a href="{{ getConfigValue('google_link') }}"><i class="fa fa-google-plus"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div><!--/header_top-->

    <div class="header-middle"><!--header-middle-->
        <div class="container">
            <div class="row">
                <div class="col-md-4 clearfix">
                    <div class="logo pull-left">
                        <a href="index.html"><img src="/eshopper/images/home/logo.png" alt="" /></a>
                    </div>
                    <div class="btn-group pull-right clearfix">
                        <div class="btn-group">
                            <button type="button" class="btn btn-default dropdown-toggle usa" data-toggle="dropdown">
                                USA
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a href="">Canada</a></li>
                                <li><a href="">UK</a></li>
                            </ul>
                        </div>

                        <div class="btn-group">
                            <button type="button" class="btn btn-default dropdown-toggle usa" data-toggle="dropdown">
                                DOLLAR
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a href="">Canadian Dollar</a></li>
                                <li><a href="">Pound</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-8 clearfix">
                    <div class="shop-menu clearfix pull-right">
                        <ul class="nav navbar-nav">

                            <li><a href=""><i class="fa fa-user"></i> Tài khoản</a></li>
                            @php
                                $carts=session()->get('cart');
                            @endphp
                            @if($carts=="")
                                <li><a href="#" onclick="Ktcart();"><i class="fa fa-crosshairs"></i> Checkout</a></li>
                            @else
                                <li><a href="{{ route('checkout') }}"><i class="fa fa-crosshairs"></i> Thanh toán</a></li>
                            @endif

                            <li><a href="{{route('showCart')}}"><i class="fa fa-shopping-cart"></i> Giỏ hàng</a></li>
                            @if (Auth::check())
                                <li>
                                    <div class="btn-group float-right">
                                        <a class="btn dropdown-toggle" data-toggle="dropdown" href="#" style="border: 0;">
                                            <i class="fa fa-lock"></i>{{ Auth::user()->name }}
                                            <span class="caret"></span>
                                        </a>
                                        <ul class="dropdown-menu">

                                            <li><i class="fas fa-sign-out-alt"></i><a href="{{ url('/logout') }}" style="margin: 5px 0;">Đăng xuất</a></li>

                                        </ul>
                                    </div>
                                </li>
                            @else
                                <li><a href="/login"><i class="fa fa-lock"></i>Đăng nhập</a></li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div><!--/header-middle-->

    <div class="header-bottom"><!--header-bottom-->
        <div class="container">
            <div class="row">
                <div class="col-sm-9">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                    </div>
                    <!--main-menu-->
                    <div class="mainmenu pull-left">
                        <ul class="nav navbar-nav collapse navbar-collapse">
                            <li><a href="{{route('home')}}" class="active">Trang chủ</a></li>
                            @foreach($categoriesLimit as $categoryParent)
                            <li class="dropdown"><a href="#">
                                {{$categoryParent->name}}
                                <i class="fa fa-angle-down"></i></a>
                                @if($categoryParent->category->count())
                                    <ul role="menu" class="sub-menu">
                                        @foreach($categoryParent->category as $categoryChild)
                                            <li class="menu-item">
                                                <a href="shop.html">{{$categoryChild->name}}</a>
                                                @if($categoryChild->category->count())
                                                    <ul role="menu" class="sub-menu1">
                                                        @foreach($categoryChild->category as $categoryLimitChild)
                                                            <li>
                                                                <a href="shop.html">{{$categoryLimitChild->name}}</a>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </li>
                            @endforeach
                            <li><a href="{{ url('/lien-he') }}">Liên hệ</a></li>
                        </ul>
                    </div>
                    <!--/main-menu-->
                </div>
                <div class="col-sm-3">
                    <div class="search_box pull-right">
                        <form action="{{ route('search') }}" method="get" role="search">
                            <input type="text" placeholder="Tìm kiếm" name="key"/>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div><!--/header-bottom-->
</header><!--/header-->
