@extends('layouts.kasir.master')
@section('header')
	<link rel="stylesheet" href="{{asset('cashier')}}/bootstrap3-editable/css/bootstrap-editable.css">
@stop
@section('content')
    <div class="row">    
        <div class="col-lg-12">
            <div class="ibox float-e-margins">               
                <div class="ibox-content">
                    <form role="form" method="GET" class="form-inline">
                        <div class="form-group">
                            <label for="cari" class="sr-only">No. Order</label>
                            <input type="text" name="order_id" placeholder="No. Order" id="cari" class="form-control" value="{{\Request::input('order_id')}}">
                        </div>                        
                        <button class="btn btn-white" type="submit">Cari</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row">

		<div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Daftar Semua Penjualan ({{auth()->user()->store->name}})</h5>                       
                       
                    </div>
                    <div class="ibox-content">

                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>CUSTOMER</th>
                                <th>TANGGAL</th>
                                <th>QTY</th>
                                <th>TOTAL HARGA</th>
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
	                                <td>
                                    {{toRp($order->total_price)}} <br>
                                    @if($order->status == 'hutang') <span class="label label-warning">- {{toRp($order->sisaHutang())}}</span> @endif
                                    </td>                                
	                                <td><span class="label @if($order->status == 'lunas') label-primary @elseif($order->status == 'draft') label-warning @else label-danger @endif">{{strtoupper($order->status)}}</span></td>                                
                                    <td>
                                        @if(in_array($order->status,['lunas','hutang']))                               
                                            <a href="{{route('penjualan.detail',$order)}}"" class="btn btn-sm btn-success">Detail</a>
                                        @endif
                                        @if($order->status == 'draft')                               
                                            <a href="{{route('penjualan.edit',$order)}}"" class="btn btn-sm btn-warning">Edit</a>
                                        @endif  

                                        @if($order->status == 'hutang')
                                            <a href="{{route('kasir.bayar.hutang.penjualan',$order)}}"" class="btn btn-sm btn-info">Bayar</a>
                                        @endif 


                                    </td>
	                            </tr>
                            @endforeach                                                        
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            {{$orders->links()}}
	</div>
@stop

@section('footer')

<script>
	$(document).ready(function(){
		
	});
</script>
@stop