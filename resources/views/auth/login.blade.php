<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title>Login</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    {!! Html::style("lte/plugins/fontawesome/css/all.min.css") !!}
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    {!! Html::style("lte/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css") !!}
    <!-- JQVMap -->
    {!! Html::style("lte/plugins/jqvmap/jqvmap.min.css") !!}
    <!-- Theme style -->
    {!! Html::style("lte/dist/css/adminlte.min.css") !!}
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <!-- /.login-logo -->
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <img style="width:90%" src="{{ asset('lte/dist/img/login-logo.png') }}" alt="">
            </div>
            <br>
            <p class="card-header text-center"></p>
            <div class="card-body">
                @if (session('status'))
                    <div class="alert alert-warning alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h5><i class="icon fas fa-exclamation-triangle"></i> Perhatian!</h5>
                        {{ session('status') }}
                    </div>
                @endif
                <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" id="id" name="id" placeholder="Username">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fal fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" id="userpassword" name="password" class="form-control" placeholder="Password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fal fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <!-- /.col -->
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block text-white">Masuk &nbsp;<i class="fal fa-sign-in-alt"></i></button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>
                <!-- /.social-auth-links -->
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    {!! Html::script('lte/plugins/jquery/jquery.min.js') !!}
    {!! Html::script('lte/plugins/jquery-ui/jquery-ui.min.js') !!}
    {!! Html::script('lte/plugins/jquery/jquery.mask.min.js') !!}
    <!-- Bootstrap 4 -->
    {!! Html::script('lte/plugins/bootstrap/js/bootstrap.bundle.min.js') !!}
    <!-- AdminLTE App -->
    {!! Html::script('lte/dist/js/adminlte.js') !!}
</body>
</html>