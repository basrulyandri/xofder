@extends('layouts.kasir.master')
@section('header')
	
@stop
@section('content')

	<div class="row">
		<div class="passwordBox animated fadeInDown">
	        <div class="row">

	            <div class="col-md-12">
	                <div class="ibox-content">

	                    <h2 class="font-bold text-danger"><i class="fa fa-lock"></i> UBAH PASSWORD</h2>                   

	                    <div class="row">

	                        <div class="col-lg-12">
	                            <form class="m-t" role="form" method="POST" action="{{route('post.kasir.ubah.password')}}">
	                            {{csrf_field()}}
	                                <div class="form-group{{$errors->has('old_password') ? ' has-error' : ''}}">
	                                    <input type="password" name="old_password" class="form-control" placeholder="Password Lama" required>
	                                    @if($errors->has('old_password'))
					                        <span class="help-block">{{$errors->first('old_password')}}</span>
					                      @endif
	                                </div>
	                                <hr>

	                                <div class="form-group{{$errors->has('new_password') ? ' has-error' : ''}}">
	                                    <input type="password" name="new_password" class="form-control" placeholder="Password Baru" required>
	                                    @if($errors->has('new_password'))
					                        <span class="help-block">{{$errors->first('new_password')}}</span>
					                      @endif
	                                </div>

	                                <div class="form-group{{$errors->has('new_password_confirmation') ? ' has-error' : ''}}">
	                                    <input type="password" name="new_password_confirmation" class="form-control" placeholder="Ulangi Password Baru" required>
	                                    @if($errors->has('new_password_confirmation'))
					                        <span class="help-block">{{$errors->first('new_password_confirmation')}}</span>
					                      @endif
	                                </div>

	                                <button type="submit" class="btn btn-primary block full-width m-b">OK</button>

	                            </form>
	                        </div>
	                    </div>
	                </div>
	            </div>
	        </div>
	    </div>
	</div>				
@stop

@section('footer')


@stop