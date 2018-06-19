@extends('layouts.kasir.master')
@section('header')
	<link rel="stylesheet" href="{{asset('cashier')}}/bootstrap3-editable/css/bootstrap-editable.css">
@stop
@section('content')
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
	                                <td>{{toRp($order->total_price)}}</td>                                
	                                <td><span class="label @if($order->status == 'lunas') label-primary @else label-danger @endif">{{strtoupper($order->status)}}</span></td>                                
                                    <td>@if(in_array($order->status,['lunas','hutang']))                               
                                        <a href="{{route('penjualan.detail',$order)}}"" class="btn btn-sm btn-success">Detail</a>
                                    @endif
                                    @if($order->status == 'draft')                               
                                        <a href="{{route('penjualan.edit',$order)}}"" class="btn btn-sm btn-warning">Edit</a>
                                    @endif                                    </td>
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