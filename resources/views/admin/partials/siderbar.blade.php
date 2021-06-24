<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/home" class="brand-link">
        <img src="{{asset('adminlte/dist/img/AdminLTELogo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
             style="opacity: .8">
        <a href="{{ url('/logout') }}" class="brand-text font-weight-light">Logout</a>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{asset('adminlte/dist/img/user2-160x160.jpg')}}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
{{--                <a href="#" class="d-block">{{auth()->user()->name}}</a>--}}
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->
                     <li class="nav-item">
                        <a href=" {{ route('infomation') }} " class="nav-link">
                            <p>
                                <i class="nav-icon fas fa-th"></i>
                                Thông tin website
                            </p>
                        </a>
                    </li>
                <li class="nav-item">
                    <a href="{{ route('categories.index') }}  " class="nav-link">
                        <p>
                            <i class="nav-icon fas fa-th"></i>
                            Danh mục sản phẩm
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('menus.index') }}  " class="nav-link">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            Menu
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href=" {{ route('product.index') }} " class="nav-link">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            Sản phẩm
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href=" {{ route('slider.index') }} " class="nav-link">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            Slider
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href=" {{ route('setting.index') }} " class="nav-link">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            Setting
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href=" {{ route('user.index') }} " class="nav-link">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            Danh sách nhân viên
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href=" {{ route('role.index') }} " class="nav-link">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            Danh sách vai trò
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href=" {{ route('permission.index') }} " class="nav-link">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            Tạo permission
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href=" {{ route('order.index') }} " class="nav-link">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            Quản lý đơn hàng
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href=" {{ route('task.index') }} " class="nav-link">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            Gửi mail cho khách
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href=" {{ route('feeship.index') }} " class="nav-link">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            Phí vận chuyển
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href=" {{ route('comment.index') }} " class="nav-link">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            Bình luận đánh giá
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
