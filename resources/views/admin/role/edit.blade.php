@extends('layouts.admin')

@section('title')
    <title>Add slider</title>
@endsection
@section('css')
    <link href="{{ asset('adminStyle/user/add/add.css') }}" rel="stylesheet" />
    <link href="{{ asset('vendor/select2/select2.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('adminStyle/role/add.css') }}" rel="stylesheet" />
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
    @include('admin.partials.content-header',['name'=>'role','key'=>'Edit'])

    <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <form method="post" action="{{ route('role.update',['id'=>$roleItem->id]) }}" enctype="multipart/form-data" style="width: 100%;">
                        <div class="col-md-12">

                            @csrf
                            <div class="form-group">
                                <label>Tên vai trò</label>
                                <input type="text"
                                       name="name"
                                       class="form-control"
                                       placeholder="Nhập tên vai trò"
                                       value="{{ $roleItem->name }}" >

                            </div>
                            <div class="form-group">
                                <label>Mô tả vai trò</label>
                                <textarea name="display_name"
                                          class="form-control"
                                          rows="5" placeholder="Nhập mô tả">{{ $roleItem->display_name }}</textarea>

                            </div>


                        </div>

                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-12">
                                    <label>
                                        <input type="checkbox" class="checkall">
                                        CheckAll
                                    </label>
                                </div>
                                @foreach($permissionParent as $permissionItem)
                                    <div class="card border-primary mb-3 col-md-12">
                                        <div class="card-header">
                                            <label>
                                                <input type="checkbox" value="" class="checkbox_wrapper">
                                            </label>
                                            Module {{$permissionItem->name}}
                                        </div>
                                        <div class="row">
                                            @foreach($permissionItem->permissionChildren as $permissionsChildrenItem)
                                                <div class="card-body text-primary col-md-3">
                                                    <h5 class="card-title">
                                                        <label>
                                                            <input type="checkbox" name="permission_id[]"
                                                                   {{$permissionsChecked->contains('id',$permissionsChildrenItem->id) ? 'checked':''}}
                                                                   value="{{$permissionsChildrenItem->id}}"
                                                                   class="checkbox_child">
                                                        </label>
                                                        {{$permissionsChildrenItem->name}}
                                                    </h5>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach

                            </div>

                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>


                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
@section('js')
    <script src="{{ asset('adminStyle/user/add/add.js') }}"></script>
    <script src="{{ asset('vendor/select2/select2.min.js') }}"></script>
    <script src="{{ asset('adminStyle/role/add.js') }}"></script>
@endsection


