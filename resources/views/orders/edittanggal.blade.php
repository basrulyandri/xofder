@extends('layouts.backend.master')
@section('header')
    <link href="{{url('assets/backend')}}/js/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css" rel="stylesheet">    
    <link rel="stylesheet" href="{{asset('assets/backend/css/plugins/datapicker/datepicker3.css')}}">
@endsection
@section('title')
  Edit Penjualan
@stop

@section('content')  
    <div class="row wrapper border-bottom white-bg page-heading">	
        <div class="col-sm-4">
            <h2>Edit Penjualan</h2>
            <ol class="breadcrumb">
                                
            </ol>
        </div>
        
    </div>   
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="ibox-content p-xl">
            <div class="row">
                <div class="col-lg-12">
                    {!!Form::open(['route' =>'orders.update.tanggal','method' => 'POST','class' => 'form-horizontal'])!!}
                         <div class='form-group{{$errors->has('orders') ? ' has-error' : ''}}'>
                            {!!Form::label('orders','No. Order',['class' => 'col-sm-2 control-label'])!!}
                            <div class="col-sm-10">
                              {!!Form::text('orders',old('orders'),['class' => 'form-control','id' => 'ordersId'])!!}
                              @if($errors->has('orders'))
                                <span class="help-block">{{$errors->first('orders')}}</span>
                              @endif
                            </div>
                          </div>

                          <div class='form-group{{$errors->has('tanggal') ? ' has-error' : ''}}'>
                              {!!Form::label('tanggal','Tanggal',['class' => 'col-sm-2 control-label'])!!}
                              <div class="col-sm-10">
                                {!!Form::text('tanggal',\Carbon\carbon::now()->format('Y-m-d'),['class' => 'form-control','placeholder' => 'Tanggal','required' => 'true','id' => 'tanggal'])!!}
                                @if($errors->has('tanggal'))
                                  <span class="help-block">{{$errors->first('tanggal')}}</span>
                                @endif
                              </div>
                            </div>

                          <div class="form-group">
                              <input type="submit" class="btn btn-info" value="Simpan">
                          </div>
                    {!!Form::close()!!}
                </div>
            </div>
        </div>
	</div>
@stop

@section('footer')   
<script type="text/javascript" src="{{url('assets/backend')}}/js/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js"></script>
<script src="{{asset('assets/backend/js/plugins/datapicker/bootstrap-datepicker.js')}}"></script>
<script>

        $(document).ready(function() {
            $("#ordersId").tagsinput('items');

            $('#tanggal').datepicker({
                format : 'yyyy-mm-dd',                
                todayBtn: "linked",                
                autoclose: true
            });
        });
    </script>
@endsection
