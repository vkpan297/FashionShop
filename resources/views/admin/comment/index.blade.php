@extends('layouts.admin')

@section('title')
    <title>List comment</title>
@endsection
@section('css')
    <link rel="stylesheet" href="{{asset('paginate.css')}}">
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
    @include('admin.partials.content-header',['name'=>'comment','key'=>'List'])
    <div id="notify-comment"></div>

    <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Tên người gửi</th>
                                <th scope="col">Bình luận</th>
                                <th scope="col">Ngày giờ</th>
                                <th scope="col">Sản phẩm</th>
                            </tr>
                            </thead>
                            <form action="">
                                @csrf
                                <tbody>
                                    @foreach( $comment as $item )
                                    @if($item->comment_parent == null)
                                        <tr>
                                            <th scope="row">{{ $item->id }}</th>
                                            <td class="comment-name">{{ $item->comment_name }}</td>
                                            <td>
                                                {{ $item->comment }}
                                                <ul>
                                                    @foreach ($comment as $comment_reply)
                                                        @if($comment_reply->comment_parent==$item->id)
                                                            <li style="list-style: decimal;
                                                            color: blueviolet;">Trả lời: {{ $comment_reply->comment }}</li>
                                                        @endif
                                                    @endforeach
                                                </ul>
                                                <br>
                                                <textarea name="reply_comment" class="form-control reply_comment_{{ $item->id }}" rows="5"></textarea>
                                                <br>
                                                <button data-product_id="{{ $item->comment_product_id }}" data-comment_id="{{ $item->id }}" class="btn btn-default btn-reply-comment">Trả lời bình luận</button>
                                            </td>
                                            <td>{{ $item->created_at }}</td>
                                            <td>{{ $item->NameProduct->name }}</td>
                                        </tr>
                                    @endif
                                    @endforeach
                                </tbody>
                            </form>

                        </table>
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
    <script src="{{ asset('adminStyle/main.js') }}"></script>
    <script>
        $('.btn-reply-comment').on('click',function(){
            var comment_id=$(this).data('comment_id');
            var comment=$('.reply_comment_'+comment_id).val();
            var comment_product_id=$(this).data('product_id');
            var comment_name=$('.comment-name').val();
            var _token=$('input[name="_token"]').val();
            $.ajax({
                    url:'{{ url('/admin/comment/reply-comment') }}' ,
                    method:'POST',
                    data:{
                        comment:comment,
                        comment_id:comment_id,
                        comment_product_id:comment_product_id,
                        comment_name:comment_name,
                        _token:_token

                    },
                    success:function(data){
                        $('#notify-comment').html('<span class="text text-alert">Trả lời bình luận thành công</span>');
                        location.reload();
                    },
            });
        });
    </script>
@endsection


