@extends('layouts.kasir.master')
@section('header')
	<link rel="stylesheet" href="{{asset('cashier')}}/bootstrap3-editable/css/bootstrap-editable.css">
@stop
@section('content')

	<div class="row">
    <div class="col-lg-12">
        <a href="{{route('penjualan.hari.ini')}}" class="btn btn-sm {{(!\Request::has('status'))? 'btn-success' : 'btn-default'}}">Selesai</a>
        <a href="{{route('penjualan.hari.ini',['status' => 'draft'])}}" class="btn btn-sm {{(\Request::has('status') && \Request::input('status') == 'draft') ? 'btn-success' : 'btn-default'}}">Draft
            @if(amountOfDraftOrders() > 0)
                <span class="badge badge-danger">{{amountOfDraftOrders()}}</span>
            @endif
        </a>
    </div>
		<div class="col-lg-9">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Daftar Penjualan hari ini ({{auth()->user()->store->name}})</h5>                        
                        <div class="ibox-tools">{{\Carbon\Carbon::today()->toDateString()}}</div>
                    </div>
                    <div class="ibox-content">

                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>WAKTU</th>
                                <th>CUSTOMER</th>
                                <th>QTY</th>
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
                                    <td>{{$order->created_at->format('d M Y')}}</td>                              
	                                <td>{{$order->customer->name}}</td>                                
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
            </div>

            <div class="col-lg-3">
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
                                <td><h5 class="pull-right">{{toRp($orders->sum('total_price') -$totaluang)}}</h5></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-lg-12">
                 <div class="ibox-content">
                    <div id="columnPenjualanProduct"></div>
                </div>
            </div>
	</div>
@stop

@section('footer')
<script type="text/javascript" src="{{asset('assets/backend/js/plugins/highcharts/highcharts.js')}}"></script>
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
        Highcharts.chart('columnPenjualanProduct', {!!json_encode($columnPenjualanProduct)!!});  
	});
</script>
@stop