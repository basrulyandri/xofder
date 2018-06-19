@extends('layouts.backend.master')
@section('header')
  
@endsection
@section('title')
  Users
@stop

@section('content')
  	<div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-4">
            <h2>Profile</h2>
            <ol class="breadcrumb">
                <li class="active">
                    <a href="{{route('users.index')}}">Users</a>
                </li>
                <li class="active">
                    <a href="{{\Request::url()}}">Profile</a>
                </li>                
            </ol>
        </div>
        <div class="col-sm-8">
            <div class="title-action">
                <a href="{{route('user.edit',['user' => $user->id] )}}" class="btn btn-warning"><i class="fa fa-edit"></i> Edit</a>
            </div>
        </div>
    </div>

    <div class="wrapper wrapper-content">
            <div class="row animated fadeInRight">
                <div class="col-md-4">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Profile Detail</h5>
                        </div>
                        <div>
                            <div class="ibox-content no-padding border-left-right">
                                <img alt="image" class="img-circle img-responsive" src="{{$user->getAvatarUrl()}}">
                            </div>
                            <div class="ibox-content profile-content">
                                <h4><strong>{{$user->getNameOrEmail(true)}}</strong></h4>
                                <p>{{$user->role->name}}</p>
                                <h5>
                                    About me
                                </h5>
                                <p>
                                    {{$user->about}}
                                </p>
                                <div class="row m-t-lg">
                                    <div class="col-md-4">
                                        <h5><strong>69</strong> Aplikan</h5>
                                    </div>
                                    <div class="col-md-4">                                        
                                        <h5><strong>158</strong> Follow Up</h5>
                                    </div>
                                    <div class="col-md-4">                                        
                                        <h5><strong>41</strong> Closing</h5>
                                    </div>
                                </div>
                                <div class="user-button">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <button type="button" class="btn btn-primary btn-sm btn-block"><i class="fa fa-envelope"></i> Kirim Pesan</button>
                                        </div>
                                        <div class="col-md-6">
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
                    </div>
                <div class="col-md-8">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Aktifitas Terakhir</h5>                            
                        </div>
                        <div class="ibox-content" style="display: block;">

                            <div>
                                <div class="feed-activity-list">                                  

                                    <div class="feed-element">
                                        <a href="#" class="pull-left">
                                            <img alt="image" class="img-circle" src="{{$user->getAvatarUrl()}}">
                                        </a>
                                        <div class="media-body ">
                                            <small class="pull-right">2h ago</small>
                                            <strong>{{$user->first_name}}</strong> Memfollow up aplikan <strong>Wahyu Purnomo</strong>. <br>
                                            <small class="text-muted">Today 2:10 pm - 12.06.2014</small>
                                            <div class="well">
                                                Akan datang pada hari Sabtu untuk tanya2 program kelas karyawan 
                                            </div>
                                            <div class="pull-right">
                                                <a class="btn btn-xs btn-white"><i class="fa fa-thumbs-up"></i> Like </a>
                                                <a class="btn btn-xs btn-white"><i class="fa fa-heart"></i> Love</a>
                                                <a class="btn btn-xs btn-primary"><i class="fa fa-pencil"></i> Message</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <button class="btn btn-primary btn-block m"><i class="fa fa-arrow-down"></i> Show More</button>

                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    
@stop

@section('footer')

@endsection
