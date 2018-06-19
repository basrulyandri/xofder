@extends('layouts.backend.master')
@section('header')
  
@endsection
@section('title')
  Users
@stop

@section('content')
  	<div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-4">
            <h2>Users</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="{{route('users.index')}}">Users</a>
                </li> 
                <li class="active">
                    <a href="{{\Request::url()}}">add</a>
                </li>                
            </ol>
        </div>
        <div class="col-sm-8">
            <div class="title-action">
                <a href="{{route('user.add')}}" class="btn btn-success"><i class="fa fa-plus"></i> Add User</a>
            </div>
        </div>
    </div>
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">                            
                            <div class="ibox-tools">
                                <a class="collapse-link binded">
                                    <i class="fa fa-chevron-up"></i>
                                </a>
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                    <i class="fa fa-wrench"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-user">
                                    <li><a href="#">Config option 1</a>
                                    </li>
                                    <li><a href="#">Config option 2</a>
                                    </li>
                                </ul>
                                <a class="close-link binded">
                                    <i class="fa fa-times"></i>
                                </a>
                            </div>
                        </div>
                        <div class="ibox-content">
                            {!!Form::open(['route' =>'user.create', 'class' => 'form-horizontal','enctype' => 'multipart/form-data'])!!}
          <div class="box-body">
            <div class='form-group{{$errors->has('username') ? ' has-error' : ''}}'>
              {!!Form::label('username','Username',['class' => 'col-sm-2 control-label'])!!}
              <div class="col-sm-10">
                {!!Form::text('username',old('username'),['class' => 'form-control','placeholder' => 'Username'])!!}
                @if($errors->has('username'))
                  <span class="help-block">{{$errors->first('username')}}</span>
                @endif
              </div>
            </div>
            
            <div class='form-group{{$errors->has('email') ? ' has-error' : ''}}'>
              {!!Form::label('email','Email',['class' => 'col-sm-2 control-label'])!!}
              <div class="col-sm-10">
                {!!Form::email('email',old('email'),['class' => 'form-control','placeholder' => 'Email'])!!}
                @if($errors->has('email'))
                  <span class="help-block">{{$errors->first('email')}}</span>
                @endif
              </div>
            </div>

            <div class='form-group{{$errors->has('role_id') ? ' has-error' : ''}}'>
              {!!Form::label('role_id','Role',['class' => 'col-sm-2 control-label'])!!}
              <div class="col-sm-10">
                {!!Form::select('role_id',$roles,old('role_id'),['class' => 'form-control'])!!}
                @if($errors->has('role_id'))
                  <span class="help-block">{{$errors->first('role_id')}}</span>
                @endif
              </div>
            </div>

            <div class='form-group{{$errors->has('store_id') ? ' has-error' : ''}}'>
              {!!Form::label('store_id','Toko',['class' => 'col-sm-2 control-label'])!!}
              <div class="col-sm-10">
                {!!Form::select('store_id',$stores,old('store_id'),['class' => 'form-control'])!!}
                @if($errors->has('store_id'))
                  <span class="help-block">{{$errors->first('store_id')}}</span>
                @endif
              </div>
            </div>

            <div class='form-group{{$errors->has('password') ? ' has-error' : ''}}'>
              {!!Form::label('password','Password',['class' => 'col-sm-2 control-label'])!!}
              <div class="col-sm-10">
                {!!Form::password('password',['class' => 'form-control','placeholder' => 'Password'])!!}
                @if($errors->has('password'))
                  <span class="help-block">{{$errors->first('password')}}</span>
                @endif
              </div>
            </div>

            <div class='form-group{{$errors->has('password_confirmation') ? ' has-error' : ''}}'>
              {!!Form::label('password_confirmation','Password Confirmation',['class' => 'col-sm-2 control-label'])!!}
              <div class="col-sm-10">
                {!!Form::password('password_confirmation',['class' => 'form-control','placeholder' => 'Password Confirmation'])!!}
                @if($errors->has('password_confirmation'))
                  <span class="help-block">{{$errors->first('password_confirmation')}}</span>
                @endif
              </div>
            </div>

            <div class='form-group{{$errors->has('phone') ? ' has-error' : ''}}'>
                {!!Form::label('phone','Phone',['class' => 'col-sm-2 control-label'])!!}
                <div class="col-sm-10">
                  {!!Form::text('phone',old('phone'),['class' => 'form-control','placeholder' => 'Phone','required' => 'true'])!!}
                  @if($errors->has('phone'))
                    <span class="help-block">{{$errors->first('phone')}}</span>
                  @endif
                </div>
            </div>

            
            <div class='form-group{{$errors->has('photo') ? ' has-error' : ''}}'>
              {!!Form::label('photo','Photo',['class' => 'col-sm-2 control-label'])!!}
              <div class="col-sm-10">
                {!!Form::file('photo',['class' => 'form-control','placeholder' => 'Photo'])!!}
                @if($errors->has('photo'))
                  <span class="help-block">{{$errors->first('photo')}}</span>
                @endif
              </div>
            </div>

          </div><!-- /.box-body -->
          <div class="box-footer">
            <button type="submit" class="btn btn-default">Cancel</button>
            <button type="submit" class="btn btn-info pull-right">Save</button>
          </div><!-- /.box-footer -->
        {!!Form::close()!!}
                        </div>
                    </div>
                </div>
        </div>        
    </div>
    
@stop

@section('footer')

@endsection
