<!--A Design by W3layouts 
Author: W3layout
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
<!DOCTYPE html>
<html>
<head>
<title>WarungMUN | Belanja Berjamaah, Mudah dan Berkah</title>
<link href="{{url('assets/frontend')}}/css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
<!--theme-style-->
<link href="{{url('assets/frontend')}}/css/style.css?ver=9" rel="stylesheet" type="text/css" media="all" />	
<link href="{{url('assets/frontend')}}/css/rollo-custom.css?ver=2" rel="stylesheet" type="text/css" media="all" />	
<link href="{{url('assets/frontend')}}/css/toastr.min.css" rel="stylesheet" type="text/css" media="all" />	
<!--//theme-style-->
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<!--fonts-->
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800' rel='stylesheet' type='text/css'>
<!--//fonts-->
<script src="{{url('assets/frontend')}}/js/jquery.min.js"></script>
<script src="{{url('assets/frontend')}}/js/toastr.min.js"></script>
@yield('header')
<!--script-->
</head>
<body> 
	<!--header-->
	<div class="header">
		<div class="top-header">
			<div class="container">
				<div class="top-header-left">
					<!-- <ul class="support">
						<li><a href="#"><label> </label></a></li>
						<li><a href="#">24x7 live<span class="live"> support</span></a></li>
					</ul> -->
					<ul class="support">
						<li class="van"><a href="#"><label> </label></a></li>
						<li><a href="#">Berjamaah, Mudah & Berkah</a></li>
					</ul>
					<div class="clearfix"> </div>
				</div>
				<div class="top-header-right">
				 	<ul class="support">						
						
						@if(\Auth::check())						
							<li><a class="btn btn-xs btn-danger" href="{{route('auth.logout')}}"><i class="fa fa-power-off"></i> Logout</a></li>
						@endif

					</ul>
					 <!---->
					<div class="clearfix"> </div>	
				</div>
				<div class="clearfix"> </div>		
			</div>
		</div>
		<div class="bottom-header">
			<div class="container">
				<div class="header-bottom-left">
					<div class="logo">
						<a href="{{route('home')}}"><img src="{{url('assets/frontend')}}/images/logo.png" alt=" " /></a>
					</div>
					<div class="search">
						{!!Form::open(['route' =>'page.search','method' => 'GET'])!!}
						<input type="text" name="q" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = '';}" >
						<input type="submit" value="CARI">
						{!!Form::close()!!}
					</div>
					<div class="clearfix"> </div>
				</div>
				<div class="header-bottom-right">	
						@if(\Auth::check())
						<div class="account"><a href="{{route('page.myaccount')}}"><span> </span>AKUN SAYA</a></div>
						@endif
						@if(!\Auth::check())
							<ul class="login">
								<li><a href="{{route('page.login')}}"><span> </span>LOGIN</a></li> |
								<li ><a href="#">DAFTAR</a></li>
							</ul>
						@endif
						<div class="cart">
							<a href="{{route('page.cart')}}">
								<span></span>
									KERANJANG 
								<p class="label label-info" id="cartInfo">
								@if(\Session::has('cart'))
								{{\Session::get('cart')->totalQty}}
								@endif
								</p>
							</a>
						</div>
					<div class="clearfix"> </div>
				</div>
				<div class="clearfix"> </div>	
			</div>
		</div>
	</div>
	<!---->
	<div class="container">
	@yield('content')	
   	
	
</body>
@yield('footer')
<script>
	$(document).ready(function(){
		@if(Session::has('toastr-success'))
			toastr.success('Berhasil','{{Session::get('toastr-success')}}');
		@endif
	});
</script>
</html>