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
                        <input class="cart_quantity_input" type="number" name="quantity" value="{{$cartItem['quantity']}}" min="1" autocomplete="off" size="2">
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

    <div class="col-md-12">
        <h2>Total: {{number_format($total)}} VND</h2>
    </div>


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
                    @php
                        $tax = $total * 1 / 100;
                        $totalSub = $total + $tax;
                    @endphp
                    <ul>
                        <li>Tổng <span>{{ number_format($total) }}</span></li>
                        <li>Thuế <span>{{ number_format($tax) }}</span></li>
                        <li>Phí vận chuyển <span>Free</span></li>
                        <li>Thành tiền <span>{{ number_format($totalSub) }}</span></li>
                    </ul>
{{--                    <a class="btn btn-default update" href="">Update</a>--}}
                    <a class="btn btn-default check_out" href="{{ route('checkout') }}">Thanh toán</a>
                </div>
            </div>
        </div>
    </div>
</section><!--/#do_action-->
@endif

