@extends('layouts.admin')

@section('title')
    <title>Add permission</title>
@endsection
@section('css')
    <link href="{{ asset('adminStyle/slider/add/add.css') }}" rel="stylesheet" />
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        @include('admin.partials.content-header',['name'=>'permission','key'=>'Add'])

        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <form method="post" action="{{ route('permission.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label>Chọn tên module</label>
                                <input type="text" class="form-control" name="module_parent" placeholder="Nhap module">
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    @foreach(config('permissions.module_child') as $moduleItemChildren)
                                    <div class="col-md-3">
                                        <label>
                                            <input type="checkbox" value="{{$moduleItemChildren}}" name="module_children[]">
                                            {{$moduleItemChildren}}
                                        </label>
                                    </div>
                                    @endforeach
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
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
    <script src="{{ asset('adminStyle/slider/add/add.js') }}"></script>
@endsection


