@extends('layouts.admin')

@section('title')
    <title>List Delivery</title>
@endsection
@section('css')
    <link rel="stylesheet" href="{{asset('paginate.css')}}">
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
    @include('admin.partials.content-header',['name'=>'delivery','key'=>'List'])
    <div class="panel-body" style="display: flex;justify-content: center;">
        <div class="position-center" style="width: 50%;">
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
                <div class="form-group">
                    <label>Phí vận chuyển</label>
                    <input type="text"
                           name="fee_ship"
                           class="form-control fee_ship"
                           placeholder="Nhập phí vận chuyển">
                </div>
                <button type="button" name="add_delivery" class="btn btn-info add_delivery" > Thêm phí vận chuyển</button>
            </form>
        </div>
    </div>
    <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12" id="load-delivery">

                    </div>
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
@section('js')
    <script src="{{ asset('vendor/sweetAleert2/sweetalert2@11.js') }}"></script>
    <script src="{{ asset('adminStyle/main.js') }}"></script>
    <script>
        $(document).ready(function (){
            fetch_delivery();
            function fetch_delivery(){
                var _token=$('input[name="_token"]').val();
                $.ajax({
                    url:'{{ url('/admin/feeship/select-feeship') }}' ,
                    method:'POST',
                    data:{
                        _token:_token,
                    },
                    success:function(data){
                        $('#load-delivery').html(data);
                    },
                });
            }
            $(document).on('blur','.fee_feeship_edit',function (){
                var feeship_id=$(this).data('feeship_id');
                var fee_value=$(this).text();
                var _token=$('input[name="_token"]').val();
                $.ajax({
                    url:'{{ url('/admin/feeship/update-delivery') }}' ,
                    method:'POST',
                    data:{
                        feeship_id:feeship_id,
                        fee_value:fee_value,
                        _token:_token,
                    },
                    success:function(data){
                        fetch_delivery();
                    },
                });
            });
            $('.add_delivery').click(function (){
                var tp=$('.tp').val();
                var qh=$('.qh').val();
                var xp=$('.xp').val();
                var fee_ship=$('.fee_ship').val();
                var _token=$('input[name="_token"]').val();
                $.ajax({
                    url:'{{ url('/admin/feeship/insert-delivery') }}' ,
                    method:'POST',
                    data:{
                        tp:tp,
                        qh:qh,
                        xp:xp,
                        _token:_token,
                        fee_ship:fee_ship
                    },
                    success:function(data){
                        fetch_delivery();
                    },
                });
            });

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
                   url:'{{ url('/admin/feeship/select-delivery') }}' ,
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
    </script>
@endsection


