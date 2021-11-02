<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
    <link rel="stylesheet" type="text/css" href="{{asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/font-awesome.css') }}">
    <title>Đăng nhập</title>
    <style></style>
</head>

<body class="cm-login">
    <div class="text-center">
        <h1 class="text-info">Hệ thống quản lí điểm(Teacher Login)</h1>
    </div>
    <div class="col-sm-6 col-md-4 col-lg-3" style="margin:40px auto; float:none;">
        <form method="POST" action="{{ route('teacher.login') }}">
            @csrf()
            <div class="col-xs-12">
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-fw fa-user"></i></div>
                        <input type="email" name="email" required class="form-control" autofocus placeholder="Email" value="teacher@gmail.com">
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-fw fa-lock"></i></div>
                        <input type="password" name="password" required class="form-control" placeholder="Mật khẩu" value="123456">
                    </div>
                </div>
            </div>
            <div class="col-xs-6">
                <div class="checkbox"><label><input type="checkbox"> Lưu mật khẩu</label></div>
            </div>
            <div class="col-xs-6">
                <button type="submit" class="btn btn-block btn-primary">Đăng nhập</button>
            </div>
        </form>
    </div>
</body>

</html>