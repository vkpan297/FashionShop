@extends('layouts.admin')

@section('title')
    <title>List setting</title>
@endsection

@section('css')
    <link href="{{ asset('adminStyle/setting/index/list.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{asset('paginate.css')}}">
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
    @include('admin.partials.content-header',['name'=>'setting','key'=>'List'])

    <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="btn-group float-right">
                            <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
                                Action
                                <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">

                                <li><a href="{{ route('setting.create') .'?type=Text' }}">Text</a></li>
                                <li><a href="{{ route('setting.create') .'?type=TextArea' }}">TextArea</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Config key</th>
                                <th scope="col">Config value</th>
                                <th scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach( $listAllSetting as $item )
                                <tr>
                                    <th scope="row">{{ $item->id }}</th>
                                    <td>{{ $item->config_key }}</td>
                                    <td>{{ $item->config_value }}</td>

                                    <td>
                                        <a href="{{ route('setting.edit',['id'=>$item->id]) . '?type=' . $item->type }}" class="btn btn-default">Edit</a>
                                        <a href="" data-url="{{ route('setting.delete',['id'=>$item->id]) }}" class="btn btn-danger action-delete">Delete</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-12">
                        {{ $listAllSetting -> links() }}
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
    <script src="{{ asset('adminStyle/setting/index/list.js') }}"></script>
@endsection


