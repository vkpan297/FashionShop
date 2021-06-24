@extends('layouts.admin')

@section('title')
    <title>Add setting</title>
@endsection
@section('css')
    <link href="{{ asset('adminStyle/slider/add/add.css') }}" rel="stylesheet" />
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        @include('admin.partials.content-header',['name'=>'setting','key'=>'Add'])

        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6">
                        <form method="post" action="{{ route('setting.store') . '?type=' . request()->type }}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label>Config key</label>
                                <input type="text"
                                       name="config_key"
                                       class="form-control @error('config_key') is-invalid @enderror"
                                       placeholder="Nhập config key"
                                       value="{{ old('config_key') }}" >
                                @error('config_key')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            @if(request()->type==='Text')
                                <div class="form-group">
                                    <label>Config value</label>
                                    <input type="text"
                                           name="config_value"
                                           class="form-control @error('config_value') is-invalid @enderror"
                                           placeholder="Nhập config value"
                                           value="{{ old('config_value') }}" >
                                    @error('config_value')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                @elseif(request()->type==='TextArea')
                                <textarea name="config_value"
                                          class="form-control @error('config_value') is-invalid @enderror"
                                          rows="5"
                                          placeholder="Nhập config value"></textarea>
                                @error('config_value')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            @endif

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


