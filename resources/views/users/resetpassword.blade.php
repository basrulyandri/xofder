<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Koperasi Syariah MUN | Login</title>

    <link href="{{url('assets/backend')}}/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{url('assets/backend')}}/font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="{{url('assets/backend')}}/css/animate.css" rel="stylesheet">
    <link href="{{url('assets/backend')}}/css/style.css" rel="stylesheet">

</head>

<body class="gray-bg">

    <div class="middle-box text-center loginscreen  animated fadeInDown">
        <div>
            <div>

                <h1 class="logo-name" style="font-size: 135px">MUN</h1>

            </div>
           
            <form class="m-t" role="form" action="{!!route('post.reset.password',['reset_password_code'=>$reset_password_code])!!}" method="post">


                <div class="form-group{{$errors->has('password') ? ' has-error' : ''}}">
                    <input type="password" class="form-control" name="password" placeholder="Password baru" required="">
                    @if($errors->has('password'))
                      <span class="help-block">{{$errors->first('password')}}</span>
                    @endif
                </div>
                
                <div class="form-group{{$errors->has('password_confirmation') ? ' has-error' : ''}}">
                    <input type="password" class="form-control" name="password_confirmation" placeholder="Konfirmasi password baru" required="">
                    @if($errors->has('password_confirmation'))
                      <span class="help-block">{{$errors->first('password_confirmation')}}</span>
                    @endif
                </div>

                <input type="hidden" name="_token" value="{{csrf_token()}}">
                <button type="submit" class="btn btn-primary block full-width m-b">Ubah Sekarang</button>
                
                
                <p class="text-muted text-center"><small>Harap memasukkan password 2 kali</small></p>
                
            </form>
            <!-- <p class="m-t"> <small>Inspinia we app framework base on Bootstrap 3 &copy; 2014</small> </p>
        </div>
    </div>

    <!-- Mainly scripts -->
    <script src="{{url('assets/backend')}}/js/jquery-2.1.1.js"></script>
    <script src="{{url('assets/backend')}}/js/bootstrap.min.js"></script>

</body>

</html>
