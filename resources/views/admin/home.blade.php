@extends('layouts.admin')

@section('title')
    <title>Trang chu</title>
@endsection
@section('css')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
    <style>
        p.title_thongke{
            text-align:center;
            font-size: 20px;
            font-weight: bold;
            width: 100%;
        }
        table.table{
            background: #32383E;
        }
        table.table tr th{
            color: #fff;
        }
        ol.list_views{
            margin: 10px 0;
            color: #fff;
            list-style-type: decimal;
            color: black;
        }
        ol.list_views a{
            font-weight: 400;
            color: orange;
        }
    </style>
@endsection
@section('js')
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script>
        $(document).ready(function(){
            chart30dayssorder();
            var chart = new Morris.Bar({
                // ID of the element in which to draw the chart.
                element: 'myfirstchart',
                // Chart data records -- each entry in this array corresponds to a point on
                // the chart.
                lineColors: ['#819C79','#fc8710','#FF6541','#A4ADD3','#766B56'],
                hideHover: 'auto',
                parseTime: false,
                // The name of the data record attribute that contains x-values.
                xkey: 'period',
                // A list of names of data record attributes that contain y-values.
                ykeys: ['order','sales','profit','quantity'],
                // Labels for the ykeys -- will be displayed when you hover over the
                // chart.
                labels: ['đơn hàng','doanh số','lợi nhuận','số lượng']

            });
            var colorDanger = "#FF1744";
                Morris.Donut({
                element: 'donut',
                resize: true,
                colors: [
                    '#ce616a',
                    '#61a1ce',
                    '#ce8f61'
                ],
                data: [
                    {label:"Sản phẩm",value:<?php echo $product ?>},
                    {label:"Đơn hàng",value:<?php echo $order ?>},
                    {label:"Khách hàng",value:<?php echo $users ?>},
                ],
                });

            function chart30dayssorder(){
                var _token=$('input[name="_token"]').val();
                $.ajax({
                    url:'{{ url('/days-order') }}' ,
                    method:'POST',
                    dataType:"JSON",
                    data:{
                        _token:_token,
                    },
                    success:function(data){
                        chart.setData(data);
                    }
                });
            }

            $('.dashboard-filter').change(function(){
                var dashboard_value=$(this).val();
                var _token=$('input[name="_token"]').val();
                $.ajax({
                    url:'{{ url('/dashboard-filter') }}' ,
                    method:'POST',
                    dataType:"JSON",
                    data:{
                        dashboard_value:dashboard_value,
                        _token:_token,
                    },
                    success:function(data){
                        chart.setData(data);
                    }
                });
            });

            $('#btn-dashboard-filter').click(function(){
                var from_date=$('#datepicker').val();
                var to_date=$('#datepicker2').val();
                var _token=$('input[name="_token"]').val();
                $.ajax({
                    url:'{{ url('/filter-by-date') }}' ,
                    method:'POST',
                    dataType:"JSON",
                    data:{
                        _token:_token,
                        from_date:from_date,
                        to_date:to_date
                    },
                    success:function(data){
                        chart.setData(data);
                    }
                });
            });
        });
    </script>
    <script>
        $(function() {
            $( "#datepicker" ).datepicker({
                prevText:"Tháng trước",
                nextText:"Tháng sau",
                dateFormat:"yy-mm-dd",
                duration:"slow"
            });
            $( "#datepicker2" ).datepicker({
                prevText:"Tháng trước",
                nextText:"Tháng sau",
                dateFormat:"yy-mm-dd",
                duration:"slow"
            });
        });
    </script>
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
    @include('admin.partials.content-header',['name'=>'Home','key'=>'home'])

    <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <p class="title_thongke">Thống kê doanh số đơn hàng</p>
                    <form autocomplete="off" style="display: flex; width: 100%;">
                        @csrf
                        <div class="col-md-2">
                            <p>Từ ngày: <input type="text" id="datepicker" class="form-control"></p>
                            <input type="button" id="btn-dashboard-filter" class="btn btn-primary btn-sm" value="Lọc kết quả"></p>
                        </div>
                        <div class="col-md-2">
                            <p>Đến ngày: <input type="text" id="datepicker2" class="form-control"></p>
                        </div>
                        <div class="col-md-2">
                            <p>
                                Lọc theo:
                                <select class="dashboard-filter form-control">
                                    <option>--Chọn--</option>
                                    <option value="7ngay">7 ngày qua</option>
                                    <option value="thangtruoc">Tháng trước</option>
                                    <option value="thangnay">Tháng này</option>
                                    <option value="365ngayqua">365 ngày qua</option>
                                </select>
                            </p>
                        </div>
                    </form>
                    <div class="col-md-12">
                        <div id="myfirstchart" style="height: 250px;"></div>
                    </div>
                </div>
                <!-- /.row -->
                <div class="row">
                    <p class="title_thongke">Thống kê truy cập</p>
                    <table class="table table-bordered table-dark">
                        <thead>
                            <tr>
                                <th scope="col">Đang online</th>
                                <th scope="col">Tổng tháng trước</th>
                                <th scope="col">Tổng tháng này</th>
                                <th scope="col">Tổng một năm</th>
                                <th scope="col">Tổng truy cập</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ $visitor_count }}</td>
                                <td>{{ $visitor_last_month_count }}</td>
                                <td>{{ $visitor_this_month_count }}</td>
                                <td>{{ $visitor_year_count }}</td>
                                <td>{{ $visitor_total }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="row">
                    <div class="col-md-4 col-xs-12">
                        <p class="title_thongke">Thống kê tổng sản phẩm đơn hàng</p>
                        <div id="donut" class="morris-donut-inverse"></div>
                    </div>
                    <div class="col-md-4 col-xs-12">
                        <h3>Sản phẩm xem nhiều</h3>
                        <ol class="list_views">
                            @foreach ($product_views as $pro)
                                <li>
                                    <a target="_blank" href="{{ route('detail',['id'=>$pro->id]) }}">{{ $pro->name }} | <span style="color: black;">{{ $pro->views_count }}</span>  </a>
                                </li>
                            @endforeach
                        </ol>
                    </div>
                </div>

            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection


