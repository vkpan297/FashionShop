@extends('layouts.admin')

@section('title')
    <title>List order</title>
@endsection

@section('css')
    <link rel="stylesheet" href="{{asset('paginate.css')}}">
@endsection

@section('js')
    <script src="{{ asset('vendor/sweetAleert2/sweetalert2@11.js') }}"></script>
    <script src="{{ asset('adminStyle/main.js') }}"></script>
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
    @include('admin.partials.content-header',['name'=>'order','key'=>'List'])

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
                                <th scope="col">Tên khách hàng</th>
                                <th scope="col">Địa chỉ</th>
                                <th scope="col">Số điện thoại</th>
                                <th scope="col">Email</th>
                                <th scope="col">Trạng thái</th>
                                <th scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach( $listOrder as $item )
                                <tr>
                                    <th scope="row">{{ $item->id }}</th>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->address }}</td>
                                    <td>{{ $item->phone }}</td>
                                    <td>{{ $item->email }}</td>
                                    @if($item->order_status == 1)
                                        <td>Chưa xử lí</td>
                                    @else
                                        <td>Đã giao hàng</td>
                                    @endif
                                    <td>
                                        <a href="{{ route('order.detail',['id'=>$item->id]) }}" class="btn btn-danger">Chi tiết</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
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


