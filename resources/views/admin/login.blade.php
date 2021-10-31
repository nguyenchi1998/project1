<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
    <link rel="stylesheet" href="{{ asset('asset/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('asset/css/bootstrap.min.css') }}">
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
                                       placeholder="Mật khẩu"
                                       value="123456">
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