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
        .iput{
            background: #F0F0E9;
            border: 0;
            border-radius: 0;
            margin-bottom: 5px;
        }
    </style>
@endsection

@section('js')
    <script src="{{asset('home/home.js')}}"></script>
    <script>
        $(document).ready(function (){
           $('.calculation_delivery').click(function (){
               var matp=$('.tp').val();
               var maqh=$('.qh').val();
               var xaid=$('.xp').val();
               var _token=$('input[name="_token"]').val();
               if(matp=='' && maqh=='' && xaid==''){
                   alert('Làm ơn chọn nơi bạn ở để tính phí vận chuy');
               }else{
                   $.ajax({
                       url:'{{ url('/checkout/calculate-fee') }}' ,
                       method:'POST',
                       data:{
                           matp:matp,
                           maqh:maqh,
                           _token:_token,
                           xaid:xaid,
                       },
                       success:function(data){
                           location.reload();
                       },
                   });
               }
           });
        });
        $(document).ready(function (){
            $('.choose').on('change',function (){
                var action=$(this).attr('id');
                var ma_id=$(this).val();
                var _token=$('input[name="_token"]').val();
                var result='';
                if(action == 'tp'){
                    result = 'qh';
                }else{
                    result = 'xp';
                }
                $.ajax({
                    url:'{{ url('/checkout/select-delivery-home') }}' ,
                    method:'POST',
                    data:{
                        action:action,
                        ma_id:ma_id,
                        _token:_token
                    },
                    success:function(data){
                        $('#'+result).html(data);
                    },
                });
            });
        });

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
                        $('.cart_items').html(data.carts);
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


            <form action="{{ route('save-checkout') }}" method="post">
                @csrf
            <div class="shopper-informations">
                <div class="row">

                        <div class="col-sm-12 clearfix" style="padding-bottom: 20px;">
                            <div class="bill-to">
                                <p>Điền thông tin gửi hàng</p>
                                <div class="form-one">

                                    <input type="text" value="{{ Auth::user()->email }}" name="email" placeholder="Email*" class="form-control iput">
                                    <input type="text" value="{{ Auth::user()->name }}" name="name" placeholder="Họ và tên" class="form-control iput">
                                    <input type="text" name="address" placeholder="Địa chỉ *" class="form-control iput">
                                    <input type="text" name="phone" placeholder="Số điện thoại" class="form-control iput">
                                    <textarea name="order_notes"  placeholder="Ghi chú đơn hàng của bạn" rows="16"></textarea>
                                    <input style="width: 100%;padding: 9px;" type="submit" value="Xác nhận đơn hàng" name="send_order" class="btn btn-primary btn-sm">

                                </div>


                            </div>
                        </div>
                        <div class="col-sm-6 clearfix">
                            <form>
                                @csrf
                                <div class="form-group">
                                    <label>Chọn thành phố</label>
                                    <select name="tp" id="tp" class="form-control input-sm m-bot15 choose tp">
                                        <option value="">--Chọn tỉnh/thành phố--</option>
                                        @foreach($tp as $itemCity)
                                            <option value="{{ $itemCity->matp }}">{{ $itemCity->name_tp }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Chọn quận huyện</label>
                                    <select name="qh" id="qh" class="form-control input-sm m-bot15 choose qh">
                                        <option value="">--Chọn quận huyện--</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Chọn xã phường</label>
                                    <select name="xp" id="xp" class="form-control input-sm m-bot15 xp">
                                        <option value="">--Chọn xã phường--</option>
                                    </select>
                                </div>
                                <input type="button"
                                       value="Tính phí vận chuyển"
                                       name="calculation_order"
                                       class="btn btn-info add_delivery calculation_delivery">
                            </form>

                        </div>


                </div>
            </div>
            <div class="review-payment">
                <h2>Giỏ hàng của bạn</h2>
            </div>

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
                    @foreach($carts as $id=>$cartItem)
                        @php
                            $total += $cartItem['price'] * $cartItem['quantity'];
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
                            $totalSub = $total + $tax + session()->get('fee');
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
                                    @if(session()->get('fee'))
                                    <td>Phí vận chuyển</td>
                                    <td>{{ number_format(session()->get('fee')) }}</td>
                                    @endif
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
            </form>





        </div>
    </section> <!--/#cart_items-->


@endsection









