<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Favicon icon -->
    <meta name="csrf-token" content="{{ csrf_token() }}">s
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('img/github.png')}}">
    <title>@yield('title_page')</title>
    <!-- Bootstrap Core CSS -->
    <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{asset('css/semantic.ui.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/pignose.calendar.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/owl.carousel.min.css')}}" rel="stylesheet" />
    <link href="{{asset('css/owl.theme.default.min.css')}}" rel="stylesheet" />
    <link href="{{asset('css/helper.css')}}" rel="stylesheet">
    <link href="{{asset('css/style.css')}}" rel="stylesheet">
    <link href="{{asset('icon/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet">

    <link rel="stylesheet" href="{{asset('css/buttons.dataTables.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/jquery.dataTables.min.css')}}">

    <style>
        label.error{
            color: red;
        }
    </style>
    @yield('header')
</head>

<body {{-- class="fix-header fix-sidebar" --}}>
    <!-- Preloader - style you can find in spinners.css -->
   {{--  <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
    </div> --}}
    <!-- Main wrapper  -->
    <div id="main-wrapper">
        <!-- header header  -->
        <div class="header">
            <nav class="navbar top-navbar navbar-expand-md navbar-light">
                <!-- Logo -->
                <div class="navbar-header">
                    <a class="navbar-brand"  href="{{route('admin.index')}}">
                        <!-- Logo icon -->
                        <b><img src="{{asset('img/img.png')}}" class="img-thumbnail" alt="homepage" class="dark-logo" /></b>
                        <!--End Logo icon -->
                        <!-- Logo text -->
                        {{-- <span><img src="images/logo-text.png" alt="homepage" class="dark-logo" /></span> --}}
                    </a>
                </div>
                <!-- End Logo -->
                <div class="navbar-collapse">
                    <div class="col-lg-10">
                       @yield('center')
                    </div>
                    <div class="col-lg-2">
                        <div class="pull-right">
                    <!-- User profile and search -->
                            <ul class="navbar-nav my-lg-0">
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle text-muted  " href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="{{asset('img/user.png')}}" alt="user" class="profile-pic" /></a>
                                    <div class="dropdown-menu dropdown-menu-right animated zoomIn">
                                        <ul class="dropdown-user">
                                            {{-- <li><a href="#"><i class="fa fa-user"></i> Thông tin cá nhân</a></li> --}}
                                            <li><a href="#" data-toggle="modal" data-target="#doimatkhau"><i class="fa fa-edit"></i> Đổi mật khẩu</a></li>
                                            <li><a href="{{route('logout')}}" onclick="return confirm('Bạn có chắc chắn đăng xuất?')"><i class="fa fa-power-off"></i> Đăng xuất</a></li>
                                        </ul>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
        <!-- Popup model đổi mật khẩu -->
        <div class="modal fade" id="doimatkhau" tabindex="-1" role="dialog" aria-labelledby="doimatkhauLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
            <form action="{{route('doiMatKhau')}}" method="get">
                <div class="modal-header">
                    <h5 class="modal-title" id="doimatkhauLabel">Tài khoản: @if(Session::has('tk_ad')) {{Session::get('tk_ad')}} @elseif(Session::has('gv')) {{Session::get('tk_ad')}} @else {{Session::get('tk_sv')}} @endif</h5>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Mật khẩu cũ</label>
                        <input type="text" class="form-control" name="txtMatKhauCu">
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Mật khẩu mới</label>
                        <textarea class="form-control" name="txtMatKhauMoi"></textarea>
                    </div>
                </div>
                <div class="modal-footer"> 
                    <button type="submit" class="btn btn-primary" {{-- onclick="return confirm('Có chắc chắn đổi')" --}}>Thực thi</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
              </div>
            </div>
            </form>
          </div>
        </div>
        <!-- End Popup model đổi mật khẩu -->
        <!-- End header header -->
        <!-- Left Sidebar  -->
        <div class="left-sidebar">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav">
                    <ul id="sidebar-nav">
                        <li class="nav-devider"></li>
                        <li class="nav-label"><img class="img-thumbnail" src="{{asset('img/logo.png')}}"></li>
                        @if(Session::has('tk_ad'))
                        <li>
                            <a  href="{{route('admin.index')}}">
                                <i class="fa fa-tachometer"></i>
                                <span class="hide-menu">Trang chủ</span>
                            </a>
                        </li>
                        <li class="nav-label">Quản lí</li>
                        <li> 
                            <a  href="{{route('danhsachadmin')}}" ><i class="fa fa-user"></i>
                                <span class="hide-menu">Quản trị viên</span>
                            </a>
                            
                        </li>
                        <li> 
                            <a href="{{route('danhsachgiaovien')}}" >
                                <i class="fa fa-suitcase"></i>
                                <span class="hide-menu">Giáo viên</span>
                            </a>
                            
                        </li>
                        <li> 
                            <a href="{{route('danhsachsinhvien')}}" >
                                <i class="fa fa-suitcase"></i>
                                <span class="hide-menu">Sinh viên</span>
                            </a>
                            
                        </li>
                        <li class="nav-label">Quản lí</li>
                        <li> 
                            <a  href="{{route('danhsachchuyennganh')}}" >
                                <i class="fa fa-wpforms"></i>
                                <span class="hide-menu">Chuyên ngành</span>
                            </a>
                            
                        </li>
                        <li> 
                            <a href="{{route('danhsachlop')}}" >
                                <i class="fa fa-suitcase"></i>
                                <span class="hide-menu">Lớp học</span>
                            </a>
                            
                        </li>
                        <li> 
                            <a href="{{route('danhsachmonhoc')}}" >
                                <i class=" fa fa-book"></i>
                                <span class="hide-menu">Môn học</span>
                            </a> 
                        </li>
                         <li> 
                            <a href="{{route('admin.danhsachlich')}}" >
                                <i class=" fa fa-table"></i>
                                <span class="hide-menu">Lịch học</span>
                            </a> 
                        </li>
                        <li> 
                            <a href="{{route('admin.viewchonchyennganh')}}" >
                                <i class="fa fa-table"></i>
                                <span class="hide-menu">Điểm thi</span>
                            </a>   
                        </li>
                        <li class="nav-label">Thống kê</li>
                        <li> 
                            <a  href="{{route('thongketheochuyennganh')}}" >
                                <i class="fa fa-bar-chart"></i>
                                <span class="hide-menu">Theo chuyên ngành</span>
                            </a>
                           
                        </li>
                        <li> 
                            <a href="{{route('thongketheolop')}}" >
                                <i class="fa fa-bar-chart"></i>
                                <span class="hide-menu">Theo lớp</span>
                            </a>
                           
                        </li>
                        <li> 
                            <a  href="{{route('viewthongketheosinhvien')}}" >
                                <i class="fa fa-bar-chart"></i>
                                <span class="hide-menu">Theo sinh viên</span>
                            </a> 
                        </li>
                        @endif
                        @if(Session::has('tk_gv'))
                        <li>
                            <a  href="#">
                                <i class="fa fa-tachometer"></i>
                                <span class="hide-menu">Trang chủ</span>
                            </a>
                        </li>
                        <li class="nav-label">Quản lí</li>
                        <li> 
                            <a  href="{{route('giaovien.viewchonlopvamonhoc')}}" ><i class="fa fa-book"></i>
                                <span class="hide-menu">Điểm</span>
                            </a>                           
                        </li>
                        @endif
                    </ul>
                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </div>
        <!-- End Left Sidebar  -->
        <!-- Page wrapper  -->
        <div class="page-wrapper">
            <!-- Bread crumb -->
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-primary">@yield('title')</h3> 
                </div>
            </div>
            <!-- End Bread crumb -->
            <!-- Container fluid  -->
            <div class="container-fluid">
                <!-- Start Page Content -->
                @yield('main')
                <!-- End PAge Content -->
            </div>
            <!-- End Container fluid  -->
            <!-- footer -->
        </div>
{{--         <footer class="footer">
            @yield('footer')
        </footer> --}}
    </div>
</body>
    <script src="{{asset('js/jquery.min.js')}}"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="{{asset('js/popper.min.js')}}"></script>
    <script src="{{asset('js/bootstrap.min.js')}}"></script>

    <script src="{{asset('js/datatables.min.js')}}"></script>
    <script src="{{asset('js/jquery.validate.min.js')}}"></script>

    <script src="{{asset('js/scripts.js')}}"></script>
    <script src="{{asset('js/Chart.min.js')}}"></script>
    
    <script type="text/javascript" src="{{asset('js/buttons.print.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/buttons.flash.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/dataTables.buttons.min.js')}}"></script>
    
    @yield('script')
</html>