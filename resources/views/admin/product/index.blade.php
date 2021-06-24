@extends('layouts.admin')

@section('title')
    <title>List Product</title>
@endsection
@section('css')
    <link href="{{ asset('adminStyle/product/index/list.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{asset('paginate.css')}}">
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
    @include('admin.partials.content-header',['name'=>'product','key'=>'List'])

    <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <a href="{{ route('product.create') }}" class="btn btn-success float-right m-2">Add</a>
                    </div>
                    <div class="col-md-12">
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Tên sản phẩm</th>
                                <th scope="col">Giá</th>
                                <th scope="col">Số lượng</th>
                                <th scope="col">Hình ảnh</th>
                                <th scope="col">Danh mục</th>
                                <th scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach( $listProduct as $item )
                                <tr>
                                    <th scope="row">{{ $item->id }}</th>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ number_format($item->price) }} VND</td>
                                    <td>{{ $item->product_quantity }}</td>
                                    <td>
                                        <img class="imgProduct" src="{{ $item->feature_image_path }}" alt="">
                                    </td>
                                    <td>{{ optional($item->category)->name }}</td>
                                    <td>
                                        <a href="{{ route('product.edit',['id'=>$item->id]) }}" class="btn btn-default">Edit</a>
                                        <a href="" data-url="{{ route('product.delete',['id'=>$item->id]) }}" class="btn btn-danger action-delete">Delete</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-12">
                        {{ $listProduct -> links() }}
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
    <script src="{{ asset('adminStyle/product/index/list.js') }}"></script>
@endsection

