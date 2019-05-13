@extends('layouts.backend.master')
@section('header')
	<link rel="stylesheet" href="{{asset('cashier')}}/bootstrap3-editable/css/bootstrap-editable.css">
    <link href="{{asset('assets/backend')}}/css/plugins/datapicker/datepicker3.css" rel="stylesheet">
    <link href="{{asset('assets/backend')}}/css/plugins/daterangepicker/daterangepicker-bs3.css" rel="stylesheet">
@stop
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">   
    <div class="col-sm-4">
        <h2>Laporan rentang waktu</h2>
        <ol class="breadcrumb">
            <li class="active">
                <a href="{{route('report.index')}}">Ringkasan</a>
            </li>                
        </ol>
    </div>
    <div class="col-sm-8">
        <div class="title-action">                  
                
    
        </div>
    </div> 
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    @if(\Request::has('rentang')) 
    <div class="row">
                    <div class="col-lg-3">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <span class="label label-success pull-right"></span>
                                <h5>Omzet</h5>
                            </div>
                            <div class="ibox-content">
                                <h1 class="no-margins">{{toRp($orders->sum('total_price'))}}</h1>                                
                                <small>Total Nilai Penjualan</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">                                
                                <h5>Profit</h5>
                            </div>
                            <div class="ibox-content">
                                <h1 class="no-margins">{{toRp($totalprofit)}}</h1>                                
                                <small>Keuntungan Penjualan</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">                                
                                <h5>Barang Keluar</h5>
                            </div>
                            <div class="ibox-content">
                                <h1 class="no-margins">{{number_format($orders->sum('total_qty'),0,',','.')}} <small>pcs</small></h1>
                                <small>Total Barang Terjual</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <h5>Pilih Rentang waktu</h5>
                               
                            </div>
                            <div class="ibox-content">                          
                            <form id="formTanggal">
                                <div class="form-group" id="data_1">
                                    <div class="input-group date">
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" name="rentang" id="tanggal" value="{{\Request::input('rentang')}}">
                                    </div>
                                </div>
                            </form>                          
                            </div>
                        </div>
            </div>
        </div>
	<div class="row">
               
		<div class="col-lg-9">               

                <div class="ibox-content">
                    <div id="columnPenjualanProduct"></div>
                </div>

            </div>

            <div class="col-lg-3">                
                <div class="ibox float-e-margins">
                    <div class="ibox-content">
                        
                    </div>
                </div>
               

                 <div class="ibox float-e-margins">    
                    <div class="ibox-title">
                        <h5>Barang Masuk</h5>                               
                    </div>                
                    <div class="ibox-content no-padding">
                        
                    </div>
                </div>

            </div>

            
                
            

           

            @else
                <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Pilih Tanggal</h5>                           
                        </div>
                        <div class="ibox-content">                          
                        <form id="formTanggal">
                            <div class="form-group" id="data_1">
                                <div class="input-group date">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" name="rentang" id="tanggal">
                                </div>
                            </div>
                        </form>                          
                        </div>
                    </div>
                </div>
            @endif
	</div>
</div>
@stop

@section('footer')
<script type="text/javascript" src="{{asset('assets/backend/js/plugins/highcharts/highcharts.js')}}"></script>
<script src="{{asset('assets/backend')}}/js/moment.min.js"></script>
<script src="{{asset('assets/backend')}}/js/plugins/datapicker/bootstrap-datepicker.js"></script>
<script src="{{asset('assets/backend')}}/js/plugins/daterangepicker/daterangepicker.js"></script>
<script>
	$(document).ready(function(){
		$('body').on('click','.btn-danger',function(){
                //alert('test');
                var id = $(this).attr('id');
                swal({
                  title:'Yakin ?',
                   text: "Mau Hapus Penjualan ini ?",
                   type: "warning",
                   showCancelButton: true,
                   confirmButtonColor: "#DD6B55",
                   confirmButtonText: "Yes, delete it!",
                   closeOnConfirm: true,
                },function(isConfirm){
                  if (isConfirm) {
                    window.location = "{{url('/')}}/kasir/penjualan/"+id+"/delete";
                  }
                });
              }); 

        // $('#tanggal').datepicker({
        //         format : 'yyyy-mm-dd',                
        //         todayBtn: "linked",                
        //         autoclose: true,
        //         format: 'yyyy-mm-dd'
        //     });
        $('#tanggal').change(function(){
            $('#formTanggal').submit();
        });
        $('#tanggal').daterangepicker({
            locale: {
                  format: 'yyyy-mm-dd'
                }
        });
        @if(\Request::has('rentang'))
        Highcharts.chart('columnPenjualanProduct', {!!json_encode($columnPenjualanProduct)!!}); 
        @endif 
	});
</script>
@stop