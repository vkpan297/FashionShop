@extends('layouts.admin')

@section('title')
    <title>List category</title>
@endsection
@section('css')
    <link rel="stylesheet" href="{{asset('paginate.css')}}">
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
    @include('admin.partials.content-header',['name'=>'category','key'=>'List'])

    <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <a href="{{route('categories.create')}}" class="btn btn-success float-right m-2">Add</a>
                    </div>
                    <div class="col-md-12">
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Tên danh mục</th>
                                <th scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach( $listCatgory as $item )
                                <tr>
                                    <th scope="row">{{ $item->id }}</th>
                                    <td>{{ $item->name }}</td>
                                    <td>

                                        <a href="{{ route('categories.edit',['id'=>$item->id]) }}" class="btn btn-default">Edit</a>
                                        <a href="" data-url="{{ route('categories.delete',['id'=>$item->id]) }}" class="btn btn-danger action-delete">Delete</a>

                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $listCatgory->onEachSide(5)->links() }}
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
@endsection


