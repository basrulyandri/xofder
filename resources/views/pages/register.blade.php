@extends('layouts.frontend.master')
@section('content')

<div class="col-sm-12">		
	<div class="wrapper">
		<form action="{{route('page.post.register')}}" method="post" name="Login_Form" class="form-signin">       
		    <h3 class="form-signin-heading">Daftar</h3>
		    	{{csrf_field()}}
		    	<input type="hidden" name="backroute" value="{{\Session::has('backroute') ? \Session::get('backroute') : ''}}">
		    	<div class="form-group{{$errors->has('nama') ? ' has-error' : ''}}">		    		
			  		<input type="text" class="form-control" value="{{old('nama')}}" name="nama" placeholder="Nama" required="" autofocus="">
			  		@if($errors->has('nama'))
			  			<span class="help-block text-danger">{{$errors->first('nama')}}</span>
			  		@endif
		    	</div>
		    	<div class="form-group{{$errors->has('email') ? ' has-error' : ''}}">
		    	<input type="text" class="form-control" value="{{old('email')}}"" name="email" placeholder="Email" required=""/>
		    	@if($errors->has('email'))
			  			<span class="help-block text-danger">{{$errors->first('email')}}</span>
			  		@endif
		    	</div>

		    	<div class="form-group{{$errors->has('phone') ? ' has-error' : ''}}">		    		
			  		<input type="text" class="form-control" value="{{old('phone')}}" name="phone" placeholder="Telpon" required="" autofocus="">
			  		@if($errors->has('phone'))
			  			<span class="help-block text-danger">{{$errors->first('phone')}}</span>
			  		@endif
		    	</div>

		    	<div class="form-group{{$errors->has('password') ? ' has-error' : ''}}">
			  		<input type="password" class="form-control" name="password" placeholder="Password" required=""/>    
			  		@if($errors->has('password'))
			  			<span class="help-block text-danger">{{$errors->first('password')}}</span>
			  		@endif 		  			
			  	</div>
			  	<div class="form-group{{$errors->has('password_confirmation') ? ' has-error' : ''}}"> 
			  		<input type="password" class="form-control" name="password_confirmation" placeholder="Konfirmasi Password" required=""/>
			  		@if($errors->has('password_confirmation'))
			  			<span class="help-block text-danger">{{$errors->first('password_confirmation')}}</span>
			  		@endif
			  	</div>
			  <button class="btn btn-lg btn-primary btn-block"  name="Submit" value="Login" type="Submit">OK</button>
			  
			  <a href="{{route('page.login')}}"><h4 class="text-center">Sudah Punya Akun? Login disini.</h4></a>
			  
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