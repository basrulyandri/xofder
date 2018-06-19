@extends('layouts.frontend.master')
@section('content')

<div class="col-sm-12">		
	<div class="wrapper">
		<form action="{{route('page.post.login')}}" method="post" name="Login_Form" class="form-signin">       
		    <h3 class="form-signin-heading">Login</h3>
		    	{{csrf_field()}}
		    	<input type="hidden" name="backroute" value="{{\Session::has('backroute') ? \Session::get('backroute') : ''}}">
			  <input type="text" class="form-control" name="email" placeholder="Username / Email" required="" autofocus="" />
			  <input type="password" class="form-control" name="password" placeholder="Password" required=""/>     		  			 
			  <button class="btn btn-lg btn-primary btn-block"  name="Submit" value="Login" type="Submit">OK</button>
			  
			  <a href="{{route('page.register')}}"><h4 class="text-center">Belum punya akun? Buat disini</h4></a>
			  
		</form>			
	</div>
</div>	
@stop

@section('footer')
<script>
	$(document).ready(function(){		
		
	});
</script>
@stop