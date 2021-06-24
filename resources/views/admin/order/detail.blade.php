@extends('layouts.admin')

@section('title')
    <title>Order Detail</title>
@endsection

@section('css')
    <link rel="stylesheet" href="{{asset('paginate.css')}}">
@endsection

@section('js')
    <script src="{{ asset('vendor/sweetAleert2/sweetalert2@11.js') }}"></script>
    <script src="{{ asset('adminStyle/main.js') }}"></script>
    <script>
        $('.btn_update_qty').click(function (){
            var order_pro_id=$(this).data('product_id');
            var order_qty=$('.order_qty_'+order_pro_id).val();
            var _token=$('input[name="_token"]').val();
            $.ajax({
                url:'{{ url('/admin/order/update-quantity') }}' ,
                method:'POST',
                data:{
                    order_pro_id:order_pro_id,
                    order_qty:order_qty,
                    _token:_token
                },
                success:function(data){
                    alert('Cập nhật số lượng thành công');
                    location.reload();
                },
            });
        });
    </script>
    <script>
        // $('.product_sale_quantity').attr('disabled', 'disabled'); //Disable
        $('.order_details').on('change',function (){
           var order_status=$(this).val();
           var order_id=$(this).children(":selected").attr("id");
           var _token=$('input[name="_token"]').val();

           //lay ra so luong
            quantity=[];
            $("input[name='product_sale_quantity']").each(function (){
                quantity.push($(this).val());
            });
            //lay ra product_id
            order_product_id=[];
            $("input[name='order_product_id']").each(function (){
                order_product_id.push($(this).val());
            });
            j=0;
            for (i=0;i<order_product_id.length;i++){
                var order_qty=$('.order_qty_'+order_product_id[i]).val();
                var order_qty_storage=$('.order_qty_storage_'+order_product_id[i]).val();
                if (parseInt(order_qty) > parseInt(order_qty_storage)){

                    j=j+1;
                    if(j==1){
                        alert('Số lượng trong kho không đủ !');
                    }
                    $('.color_qty_'+order_product_id[i]).css('background','red');
                }
            }
            if(j==0){
                $.ajax({
                    url:'{{ url('/admin/order/update-order-quantity') }}' ,
                    method:'POST',
                    data:{
                        order_status:order_status,
                        order_id:order_id,
                        quantity:quantity,
                        order_product_id:order_product_id,
                        _token:_token
                    },
                    success:function(data){
                        alert('Thay đổi trạng thái đơn hàng thành công');
                        location.reload();
                    },
                });
            }

        });
    </script>

@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
    @include('admin.partials.content-header',['name'=>'order','key'=>'Detail'])

    <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    {{--                    <div class="col-md-12">--}}
                    {{--                        <a href="{{ route('menus.create') }}" class="btn btn-success float-right m-2">Add</a>--}}
                    {{--                    </div>--}}
                    <div class="col-md-12">
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Tên sản phẩm</th>
                                <th scope="col">Số lượng kho còn</th>
                                <th scope="col">Giá sản phẩm</th>
                                <th scope="col">Số lượng đặt hàng</th>
                                <th scope="col">Ngày mua</th>
                                <th scope="col">Tổng tiền</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach( $orderDetail as $key=>$item )
                                @php
                                    $total += $item['product_price'] * $item['product_quantity'];
                                @endphp
                                <tr class="color_qty_{{$item->product_id}}">
                                    <th scope="row">{{ $item->id }}</th>
                                    <td>{{ $item->product_name }}</td>
                                    <td>{{ $item->order->product_quantity }}</td>
                                    <td>{{ number_format($item->product_price) }}</td>
                                    <td>
                                        <input type="number" {{$order_status==2 ? 'disabled' : ''}} name="product_sale_quantity" min="0" class="order_qty_{{$item->product_id}}" value="{{ $item->product_quantity }}">
                                        @if($order_status != 2)
                                            <button data-product_id="{{$item->product_id}}" name="btn_update_qty" class=" btn_update_qty btn btn-primary">Cập nhật</button>
                                        @endif()
                                    </td>
                                    <input type="hidden" name="order_qty_storage" class="order_qty_storage_{{$item->product_id}}" value="{{ $item->order->product_quantity }}">
                                    <input type="hidden" name="order_product_id" class="order_product_id" value="{{ $item->product_id }}">
                                    <td>{{ $item->created_at }}</td>
                                    <td>{{ number_format($item->product_price * $item->product_quantity) }}</td>
                                </tr>
                            @endforeach
                            <tr>
                                <td colspan="6">
                                    @foreach($order as $key=>$or)
                                        @if($or->order_status==1)
                                            <form>
                                                @csrf
                                                <select class="form-control order_details">
                                                    <option value="">----Chọn hình thức đơn hàng----</option>
                                                    <option id="{{ $or->id }}" selected value="1">Chưa xử lí</option>
                                                    <option id="{{ $or->id }}" value="2">Đã xử lí - Đã giao hàng</option>
                                                </select>
                                            </form>
                                        @else
                                            <form>
                                                @csrf
                                                <select class="form-control order_details">
                                                    <option value="">----Chọn hình thức đơn hàng----</option>
                                                    <option disabled id="{{ $or->id }}" value="1">Chưa xử lí</option>
                                                    <option id="{{ $or->id }}" selected value="2">Đã xử lí - Đã giao hàng</option>
                                                </select>
                                            </form>
                                        @endif
                                    @endforeach
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <div class="col-md-12">
                            <h3>Tổng giá tiền sản phẩm: {{ number_format($total) }} VND</h3>
                        </div>
                    </div>
                    {{--                    <div class="col-md-12">--}}
                    {{--                        {{ $listmenus -> links() }}--}}
                    {{--                    </div>--}}
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection


