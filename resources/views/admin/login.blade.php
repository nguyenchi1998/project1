<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet"
          href="{{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- JQVMap -->
    <link rel="stylesheet" href="{{ asset('plugins/jqvmap/jqvmap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}">
    <!-- summernote -->
    <link rel="stylesheet" href="{{ asset('plugins/summernote/summernote-bs4.min.css') }}">
    <!-- custom -->
    <link rel="stylesheet" href="{{ asset('dist/css/custom.css') }}">
    <title>Đăng nhập</title>
    <style></style>
</head>

<body>
<div class="container-fluid">
    <div class="d-flex justify-content-center align-items-center" style="height: 100vh">
        <div class="d-block">
            <div class="text-center">
                <h1 class="text-info">Hệ thống quản lí điểm</h1>
            </div>
            <div class="m-auto" style="max-width: 400px">
                <form method="POST" action="{{ route('admin.login') }}">
                    @csrf()
                    <div class="col-xs-12">
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="mdi mdi-24px mdi-account"></i>
                                </div>
                                <input type="email" name="email" required class="form-control" autofocus
                                       placeholder="Email" value="admin@gmail.com">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="mdi mdi-24px mdi-lock"></i>
                                </div>
                                <input type="password" name="password" required class="form-control"
                                       placeholder="Mật khẩu" value="123456">
                            </div>
                        </div>
                    </div>
                    <div class="">
                        <div class="checkbox">
                            <label><input type="checkbox"> Lưu mật khẩu</label>
                        </div>
                    </div>
                    <div class="col-xs-6">
                        <button type="submit" class="btn btn-block btn-primary">Đăng nhập</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</body>

</html>