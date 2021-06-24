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
        .cart_quantity{
            display: flex;
            justify-content: center;
        }
        .cart_quantity_input{
            width: 100px;
        }
    </style>
@endsection

@section('js')
    <script src="{{asset('home/home.js')}}"></script>
    <script>
        function cartUpdate(event){
            event.preventDefault();
            var qty=$('.cart_quantity_input').val();
            var max_qty=$('.cart_quantity_max').val();
            let url=$('.update_cart_url').data('url');
            let id=$(this).data('id');
            let quantity=$(this).parents('tr').find('input.cart_quantity_input').val();
            if(qty>max_qty){
                alert('Số lượng bạn nhập vào vượt quá số lượng trong kho! Vui lòng nhập lại !');
            }else{
                $.ajax({
                    type:"GET",
                    url:url,
                    data:{
                        id:id,
                        quantity:quantity,
                    },
                    success:function (data){
                        if(data.code === 200){
                            location.reload();
                            alert('Cập nhật thành công');
                        }
                    },
                    error:function (){

                    }
                })
            }

        }

        function cartDelete(event){
            event.preventDefault();
            let urlDelete=$('.cart_info').data('url');
            let id=$(this).data('id');
            $.ajax({
                type:"GET",
                url:urlDelete,
                data:{
                    id:id,
                },
                success:function (data){
                    if(data.code === 200){
                        location.reload();
                        alert('Xóa thành công');
                    }
                },
                error:function (){

                }
            });
        }
        $(function (){
            $(document).on('click','.cart_update',cartUpdate);
            $(document).on('click','.cart_deletes',cartDelete);
        });
    </script>
@endsection

@section('content')

    <section id="cart_items" class="cart_items">
        <div class="container">
            <div class="breadcrumbs">
                <ol class="breadcrumb">
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li class="active">Shopping Cart</li>
                </ol>
            </div>
            @if($carts=="")
                <div class="table-responsive cart_info"  data-url="{{ route('deleteCart') }}">
                    <table class="table table-condensed update_cart_url" data-url="{{ route('updateCart') }}">
                        <thead>
                        <tr class="cart_menu">
                            <td class="image">Ảnh sản phẩm</td>
                            <td class="description">Tên</td>
                            <td class="description">Giá</td>
                            <td class="description">Số lượng</td>
                            <td class="description">Sub Total</td>
                            <td class="price">Action</td>
                            <td></td>
                        </tr>
                        </thead>
                    </table>
                </div>
            @else
                <div class="table-responsive cart_info"  data-url="{{ route('deleteCart') }}">
                    <table class="table table-condensed update_cart_url" data-url="{{ route('updateCart') }}">
                        <thead>
                        <tr class="cart_menu">
                            <td class="image">Ảnh sản phẩm</td>
                            <td class="description">Tên</td>
                            <td class="description">Giá</td>
                            <td class="description">Số lượng</td>
                            <td class="description">Sub Total</td>
                            <td class="price">Action</td>
                            <td></td>
                        </tr>
                        </thead>
                        <tbody>
                        @php
                            $total=0;
                        @endphp
                        @foreach($carts as $id=>$cartItem)
                            @php
                                $total = $total + $cartItem['price'] * $cartItem['quantity']
                            @endphp
                            <tr>
                                <td class="cart_product">
                                    <a href=""><img style="width: 200px;" src="{{$cartItem['image']}}" alt=""></a>
                                </td>
                                <td class="cart_description">
                                    <h4><a href="">{{$cartItem['name']}}</a></h4>
                                    <p>Product ID: {{$id}}</p>
                                </td>
                                <td class="cart_price">
                                    <p>{{number_format($cartItem['price'])}}</p>
                                </td>
                                <td class="cart_quantity">
                                    <div class="cart_quantity_button">
                                        <input class="cart_quantity_input" type="number" name="quantity" value="{{$cartItem['quantity']}}" min="1" max="{{$cartItem['max_qty']}}"  autocomplete="off" size="2">
                                        <input class="cart_quantity_max" type="hidden" name="quantity" value="{{$cartItem['max_qty']}}"  autocomplete="off" size="2">
                                    </div>
                                </td>
                                <td class="cart_total">
                                    <p class="cart_total_price">{{number_format($cartItem['price'] * $cartItem['quantity']) }}</p>
                                </td>
                                <td class="">
                                    <a href=""
                                       data-id="{{ $id }}"
                                       style="margin: 0;"
                                       class="btn btn-primary cart_update">Cập nhật</a>
                                    <a href="" data-id="{{ $id }}" class="btn btn-danger cart_deletes">Xóa</a>
                                </td>
                            </tr>
                        @endforeach
                        <tr>
                            @php
                                $tax = $total * 1 / 100;
                                $totalSub = $total + $tax;
                            @endphp
                            <td colspan="4">&nbsp;</td>
                            <td colspan="2">
                                <table class="table table-condensed total-result">
                                        <tr>
                                            <td>Tổng</td>
                                            <td>{{ number_format($total) }}</td>
                                        </tr>
                                        <tr>
                                            <td>Thuế</td>
                                            <td>{{ number_format($tax) }}</td>
                                        </tr>
                                        <tr class="shipping-cost">
                                            <td>Phí vận chuyển</td>
                                            <td>Free</td>
                                        </tr>
                                        <tr>
                                            <td>Thành tiền</td>
                                            <td><span>{{ number_format($totalSub) }}</span></td>
                                        </tr>
                                </table>
                            </td>
                        </tr>
                        </tbody>
                    </table>


                </div>
                <section id="do_action">
                    <div class="container">
                        <div class="heading">
                            <h3>What would you like to do next?</h3>
                            <p>Choose if you have a discount code or reward points you want to use or would like to estimate your delivery cost.</p>
                        </div>
                        <div class="row">

                            <div class="col-sm-12">
                                    <div class="total_area">
                                        <ul>
                                            <li>Tổng <span>{{ number_format($total) }}</span></li>
                                            <li>Thuế <span>{{ number_format($tax) }}</span></li>
                                            <li>Phí vận chuyển <span>Free</span></li>
                                            <li>Thành tiền <span>{{ number_format($totalSub) }}</span></li>
                                        </ul>
                                        <a class="btn btn-default check_out" href="{{ route('checkout') }}">Thanh toán</a>
                                    </div>
                            </div>
                        </div>
                    </div>
                </section><!--/#do_action-->

            @endif



        </div>
    </section> <!--/#cart_items-->


@endsection









