@extends('layouts.kasir.master')
@section('header')
	<link rel="stylesheet" href="{{asset('cashier')}}/bootstrap3-editable/css/bootstrap-editable.css">
    <link href="{{asset('assets/backend')}}/css/plugins/datapicker/datepicker3.css" rel="stylesheet">
@stop
@section('content')

	<div class="row">
        @if(\Request::has('tanggal'))
        <div class="col-lg-12">
            <a href="{{url()->full()}}&print=true" class="btn btn-primary"><i class="fa fa-print"></i> Print All</a>
        </div>
		<div class="col-lg-9">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Penjualan ({{auth()->user()->store->name}})</h5>                        
                        <div class="ibox-tools">{{\Carbon\Carbon::parse(\Request::input('tanggal'))->format('d M Y')}}</div>
                    </div>
                    <div class="ibox-content">

                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>CUSTOMER</th>
                                <th>BARANG</th>
                                <th>TOTAL QTY</th>
                                <th>TOTAL HARGA</th>
                                <th>BAYAR</th>
                                <th>STATUS</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($orders as $order)
	                            <tr>
	                                <td>{{$order->id}}</td>  
	                                <td>{{$order->customer->name}}</td>  
                                    <td>
                                        @foreach($order->items as $item)
                                            <small>{{$item->product->name}} ({{$item->qty}})</small><br>
                                        @endforeach
                                    </td>                              
	                                <td>{{$order->total_qty}}</td>                                
	                                <td>{{toRp($order->total_price)}}</td> 
                                    <td>{{toRp($order->pembayaran->sum('nominal'))}}</td>                               
	                                <td><span class="label @if($order->status == 'lunas') label-primary @else label-danger @endif">{{strtoupper($order->status)}}</span></td> 
	                                <td>
                                    @if(in_array($order->status,['lunas','hutang']))                               
                                        <a href="{{route('penjualan.detail',$order)}}"" class="btn btn-sm btn-success">Detail</a>
                                    @endif
                                    @if($order->status == 'draft')                               
                                        <a href="{{route('penjualan.edit',$order)}}"" class="btn btn-sm btn-warning">Edit</a>
                                    @endif    
                                    <a href="{{route('order.print',$order)}}" class="btn btn-sm btn-primary"><i class="fa fa-print"></i> Print</a>                                
                                        <button id="{{$order->id}}" class="btn btn-sm btn-danger">Hapus</a>
	                                </td>
	                            </tr>
                            @endforeach                            
                           
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="ibox-content">
                    <div id="columnPenjualanProduct"></div>
                </div>

            </div>

            <div class="col-lg-3">
                <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <h5>Pilih Tanggal</h5>
                               
                            </div>
                            <div class="ibox-content">                          
                            <form id="formTanggal">
                                <div class="form-group" id="data_1">
                                    <div class="input-group date">
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" name="tanggal" id="tanggal" value="{{\Request::input('tanggal')}}">
                                    </div>
                                </div>
                            </form>                          
                            </div>
                        </div>
                <div class="ibox float-e-margins">
                    <div class="ibox-content">
                        <table>
                            <tr>
                                <td><h5>TOTAL QTY:</h5></td>
                                <td><h5 class="pull-right"> {{$orders->sum('total_qty')}} PCS</h5></td>
                            </tr>
                            <tr>
                                <td><h5>TOTAL HARGA:</h5></td>
                                <td><h5 class="pull-right">{{toRp($orders->sum('total_price'))}}</h3></td>
                            </tr>
                            <tr>
                                <td><h5>UANG MASUK:</h5></td>
                                <td><h5 class="pull-right">{{toRp($totaluang)}}</h5></td>
                            </tr>

                            <tr>
                                <td><h5>UANG PENDING:</h5></td>
                                <td><h5 class="pull-right">{{toRp($orders->sum('total_price') - $totaluang)}}</h5></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="ibox float-e-margins">    
                    <div class="ibox-title">
                        <h5>Barang Terjual</h5>                               
                    </div>                
                    <div class="ibox-content no-padding">
                        <ul class="list-group">
                            @foreach($productSold as $ps)
                            <li class="list-group-item">
                                <span class="badge badge-primary">{{$ps->ordersItem()->whereDate('created_at','=',\Carbon\Carbon::parse(\Request::input('tanggal')))->sum('qty')}}</span>
                                {{$ps->name}}
                            </li>
                            @endforeach
                            
                        </ul>
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
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" name="tanggal" id="tanggal">
                                </div>
                            </div>
                        </form>                          
                        </div>
                    </div>
                </div>
            @endif
	</div>
@stop

@section('footer')
<script type="text/javascript" src="{{asset('assets/backend/js/plugins/highcharts/highcharts.js')}}"></script>
<script src="{{asset('assets/backend')}}/js/plugins/datapicker/bootstrap-datepicker.js"></script>
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

        $('#tanggal').datepicker({
                format : 'yyyy-mm-dd',                
                todayBtn: "linked",                
                autoclose: true,
                format: 'yyyy-mm-dd'
            });
        $('#tanggal').change(function(){
            $('#formTanggal').submit();
        });
        @if(\Request::has('tanggal'))
        Highcharts.chart('columnPenjualanProduct', {!!json_encode($columnPenjualanProduct)!!}); 
        @endif 
	});
</script>
@stop