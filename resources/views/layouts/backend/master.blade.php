<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title')</title>

    <link href="{{url('assets/backend')}}/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{url('assets/backend')}}/font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="{{url('assets/backend')}}/css/animate.css" rel="stylesheet">
    <link href="{{url('assets/backend')}}/css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="{!!url('assets/backend')!!}/js/plugins/sweetalert/sweetalert.css">
    <link href="{{url('assets/backend')}}/css/rollo-custom.css?ver=3" rel="stylesheet">
    @yield('header')
</head>

<body>

    <div id="wrapper">

   @include('layouts.backend.sidebar')

        <div id="page-wrapper" class="gray-bg">
        <div class="row border-bottom">
        <nav class="navbar navbar-static-top  " role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
            <img src="{{asset('assets/backend/img/logo.png')}}" alt="" style="margin-left: 30px;width: 270px;height: 60px;">
        </div>
            <ul class="nav navbar-top-links navbar-right">
                <li>
                    <a href="{{route('auth.logout')}}">
                        <i class="fa fa-sign-out"></i> Log out
                    </a>
                </li>
            </ul>

        </nav>
        </div>

        @yield('content')
        <div class="footer">
                <div class="pull-right">
                    Created by <strong><a target="_blank" href="http://rolloic.com">Rollo ITC</a></strong>
                </div>
                <div>
                    <strong>Copyright</strong> Koperasi Syariah Masalahat Untuk Negeri @2017
                </div>
            </div>

        </div>
        </div>

    <!-- Mainly scripts -->
    <script src="{{url('assets/backend')}}/js/jquery-2.1.1.js"></script>
    <script src="{{url('assets/backend')}}/js/bootstrap.min.js"></script>
    <script src="{{url('assets/backend')}}/js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="{{url('assets/backend')}}/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
    <script src="{!!url('assets/backend')!!}/js/plugins/sweetalert/sweetalert.min.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="{{url('assets/backend')}}/js/inspinia.js"></script>
    <script src="{{url('assets/backend')}}/js/plugins/pace/pace.min.js"></script>
    <script>
        @if(Session::has('success'))
          swal({title: "Success",
                type: 'success',
                text: "{{Session::get('success')}} !",
                timer: 3000,
                showConfirmButton: true });
          @endif

          @if(Session::has('warning'))
            swal({title: "SURE ?",
                  type: 'warning',
                  text: "{{Session::get('success')}} !",
                  timer: 3000,
                  showConfirmButton: true });
          @endif

          @if(Session::has('error'))
            swal({title: "ERROR",
                  type: 'error',
                  text: "{{Session::get('error')}} !",
                  timer: 3000,
                  showConfirmButton: true });
          @endif
    </script>
    @yield('footer')
</body>

</html>