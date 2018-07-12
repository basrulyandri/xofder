<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{config('rollo-inventor.APP_NAME')}}</title>

    <link href="{{asset('assets/backend')}}/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{asset('assets/backend')}}/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="{{asset('assets/backend')}}/css/animate.css" rel="stylesheet">
    <link href="{{asset('assets/backend')}}/css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="{!!url('assets/backend')!!}/js/plugins/sweetalert/sweetalert.css">
    <link rel="stylesheet" href="{{asset('assets/backend/js/plugins/jquery-ui/jquery-ui.min.css')}}">
    <link rel="stylesheet" href="{{asset('cashier/css/select2.min.css')}}">
    @yield('header')

</head>

<body class="top-navigation">

    <div id="wrapper">
        <div id="page-wrapper" class="gray-bg">
        <div class="row border-bottom white-bg">
        <nav class="navbar navbar-static-top" role="navigation">
            <div class="navbar-header">
                <button aria-controls="navbar" aria-expanded="false" data-target="#navbar" data-toggle="collapse" class="navbar-toggle collapsed" type="button">
                    <i class="fa fa-reorder"></i>
                </button>
                <a href="#" class="navbar-brand">{{auth()->user()->store->name}}</a>

            </div>
            <div class="navbar-collapse collapse" id="navbar">
                <ul class="nav navbar-nav">
                    <li class="active">
                        <a aria-expanded="false" role="button" href="{{route('kasir.index')}}">Home</a>
                    </li>
                    <li class="dropdown">
                        <a aria-expanded="false" role="button" href="#" class="dropdown-toggle" data-toggle="dropdown"> Penjualan <span class="caret"></span></a>
                        <ul role="menu" class="dropdown-menu">
                            <li><a href="{{route('penjualan.hari.ini')}}">Hari Ini</a></li>
                            <li><a href="{{route('penjualan.hari.tertentu')}}">Hari Tertentu</a></li>
                            <li><a href="{{route('penjualan.semua')}}">Semua</a></li>                            
                        </ul>
                    </li>

                    <li><a href="{{route('kasir.stocks.index')}}">Stocks 
                    @if(amountOfProductsHasMinimunStock() > 0)
                    <span class="badge badge-danger">{{amountOfProductsHasMinimunStock()}}</span>
                    @endif
                    </a></li>
                    <li><a href="{{route('kasir.report')}}">Laporan</a></li>
                </ul>
                <ul class="nav navbar-top-links navbar-right">
                    <li class="dropdown">
                        <a aria-expanded="false" role="button" href="#" class="dropdown-toggle" data-toggle="dropdown"> Halo, {{auth()->user()->username}} <span class="caret"></span></a>
                        <ul role="menu" class="dropdown-menu">
                            <li><a href="{{route('kasir.ubah.password')}}"><i class="fa fa-lock"></i> Ubah Password</a></li>
                            <li><a href="{{route('auth.logout')}}"><i class="fa fa-sign-out"></i> Log out</a></li>                         
                        </ul>
                    </li>                    
                </ul>
            </div>
        </nav>
        </div>
        <div class="wrapper wrapper-content">
            <div class="container">
            	@yield('content')
            </div>

        </div>
        <div class="footer">
            <div class="pull-right">
                <a href="http://rolloic.com">rolloic.com</a>
            </div>
            <div>
                Hak Cipta<strong> Basrul Yandri</strong> @2018
            </div>
        </div>

        </div>
        </div>



    <!-- Mainly scripts -->
    <script src="{{asset('assets/backend')}}/js/jquery-2.1.1.js"></script>
    <script src="{{asset('assets/backend')}}/js/bootstrap.min.js"></script>
    <script src="{{asset('assets/backend')}}/js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="{{asset('assets/backend')}}/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
    <script src="{!!url('assets/backend')!!}/js/plugins/sweetalert/sweetalert.min.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="{{asset('assets/backend')}}/js/inspinia.js"></script>
    <script src="{{asset('assets/backend')}}/js/plugins/pace/pace.min.js"></script>    
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
            swal({title: "Oooops",
                  type: 'error',
                  text: "{{Session::get('error')}} !",
                  timer: 3000,
                  });
          @endif
    </script>
@yield('footer')
</body>

</html>
