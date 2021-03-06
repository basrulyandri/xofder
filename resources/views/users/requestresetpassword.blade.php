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
                @if(\Session::has('message-warning'))
                <div class="alert alert-warning">
                    <p><i class="fa fa-warning"></i> {{session('message-warning')}}</p>
                </div>
                @endif

                @if(\Session::has('message-success'))
                <div class="alert alert-success">
                    <p><i class="fa fa-check"></i> {{session('message-success')}}</p>
                </div>
                @endif

            </div>
           
            <form class="m-t" role="form" action="{!!route('post.request.reset.password')!!}" method="post">
                <div class="form-group">
                    <input type="email" class="form-control" name="email" placeholder="Email" required="">
                </div>                
                <input type="hidden" name="_token" value="{{csrf_token()}}">
                <button type="submit" class="btn btn-primary block full-width m-b">Kirim</button>                
                
                <p class="text-muted text-center"><small>Untuk keamanan, Kami akan mengirimkan link reset password ke email anda.</small></p>                
            </form>
            <!-- <p class="m-t"> <small>Inspinia we app framework base on Bootstrap 3 &copy; 2014</small> </p> -->
        </div>
    </div>

    <!-- Mainly scripts -->
    <script src="{{url('assets/backend')}}/js/jquery-2.1.1.js"></script>
    <script src="{{url('assets/backend')}}/js/bootstrap.min.js"></script>

</body>

</html>
