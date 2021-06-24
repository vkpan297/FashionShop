@extends('layouts.admin')

@section('title')
    <title>Add slider</title>
@endsection
@section('css')
    <link href="{{ asset('adminStyle/user/add/add.css') }}" rel="stylesheet" />
    <link href="{{ asset('vendor/select2/select2.min.css') }}" rel="stylesheet" />
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        @include('admin.partials.content-header',['name'=>'user','key'=>'Add'])

        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6">
                        <form method="post" action="{{ route('user.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label>Tên</label>
                                <input type="text"
                                       name="name"
                                       class="form-control"
                                       placeholder="Nhập tên "
                                       value="{{ old('name') }}" >

                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="text"
                                       name="email"
                                       class="form-control"
                                       placeholder="Nhập email"
                                       value="{{ old('email') }}" >

                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password"
                                       name="password"
                                       class="form-control"
                                       placeholder="Nhập password"
                                       >

                            </div>
                            <div class="form-group">
                                <label>Chọn vai trò</label>
                                <select name="role_id[]" class="form-control select2_init" multiple>
                                    <option value="">admin</option>
                                    @foreach($roles as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>

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
    <script src="{{ asset('adminStyle/user/add/add.js') }}"></script>
    <script src="{{ asset('vendor/select2/select2.min.js') }}"></script>
@endsection


