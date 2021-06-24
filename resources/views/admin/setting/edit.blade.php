@extends('layouts.admin')

@section('title')
    <title>Edit setting</title>

@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
    @include('admin.partials.content-header',['name'=>'setting','key'=>'Edit'])

    <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6">
                        <form method="post" action="{{ route('setting.update',['id'=>$settingItem->id]) }}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label>Config key</label>
                                <input type="text" name="config_key" value="{{ $settingItem->config_key }}" class="form-control" placeholder="Nhập tên danh mục">
                            </div>

                            @if(request()->type==='Text')
                                <div class="form-group">
                                    <label>Config value</label>
                                    <input type="text"
                                           name="config_value"
                                           class="form-control @error('config_value') is-invalid @enderror"
                                           placeholder="Nhập config value"
                                           value="{{ $settingItem->config_value }}" >

                                </div>
                            @elseif(request()->type==='TextArea')
                                <textarea name="config_value"
                                          class="form-control @error('config_value') is-invalid @enderror"
                                          rows="5"
                                          placeholder="Nhập config value">{{ $settingItem->config_value }}</textarea>

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


