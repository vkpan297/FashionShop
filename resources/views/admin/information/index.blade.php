@extends('layouts.admin')

@section('title')
    <title>Cập nhật thông tin website</title>

@endsection
@section('css')
    <link href="{{ asset('vendor/select2/select2.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('adminStyle/product/add/add.css') }}" rel="stylesheet" />
@endsection
@section('js')
    <script src="{{ asset('vendor/select2/select2.min.js') }}"></script>
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <script src="{{ asset('adminStyle/product/add/add.js') }}"></script>

@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        @include('admin.partials.content-header',['name'=>'information','key'=>'Add'])

        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    @foreach ($contact as $value)
                    <form method="post" action="{{ route('contact.update',['id'=>$value->id]) }}) }}" style="width: 100%;" enctype="multipart/form-data">
                        @csrf
                    <div class="col-md-6">
                            <div class="form-group">
                                <label>Bản đồ</label>
                                <textarea name="map" id="" rows="8" class="form-control">{{ $value->map }}</textarea>
                            </div>
                            <div class="form-group">
                                <label>Fanpage</label>
                                <textarea name="fanpage" id="" rows="8" class="form-control">{{ $value->fanpage }}</textarea>
                            </div>
                            <div class="form-group">
                                <label>Hình ảnh logo</label>
                                <input type="file" name="image" class="form-control-file">
                                <div class="col-md-12">
                                    <div class="row">
                                        <img src="{{ $value->image }}" alt="" width="150px" height="150px">
                                    </div>
                                </div>
                            </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Thông tin liên hệ</label>
                            <textarea class="form-control tinymce_editor_init"
                                      id="exampleFormControlTextarea1"
                                      name="contact" rows="8">{{ $value->contact }}</textarea>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Cập nhật thông tin</button>
                        </form>
                        @endforeach
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection


