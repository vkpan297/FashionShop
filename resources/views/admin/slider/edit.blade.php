@extends('layouts.admin')

@section('title')
    <title>Edit slider</title>

@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
    @include('admin.partials.content-header',['name'=>'slider','key'=>'Edit'])

    <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6">
                        <form method="post" action="{{ route('slider.update',['id'=>$sliderItem->id]) }}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label>Tên slider</label>
                                <input type="text" name="name" value="{{ $sliderItem->name }}" class="form-control" placeholder="Nhập tên danh mục">
                            </div>

                            <div class="form-group">
                                <label>Mô tả slider</label>
                                <textarea name="description"
                                          rows="5"
                                          class="form-control">{{ $sliderItem->description }}</textarea>
                            </div>
                            <div class="form-group">
                                <label>Hình ảnh</label>
                                <input type="file" name="image_path" class="form-control-file">
                                <div class="col-md-12">
                                    <div class="row">
                                        <img src="{{ $sliderItem->image_path }}" alt="" width="150px" height="150px">
                                    </div>
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


