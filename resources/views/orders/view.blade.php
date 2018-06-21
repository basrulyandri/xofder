@extends('layouts.backend.master')
@section('header')
    <link href="{{url('assets/backend')}}/css/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet">
    <link href="{{url('assets/backend')}}/css/plugins/dataTables/dataTables.responsive.css" rel="stylesheet">
    <link href="{{url('assets/backend')}}/css/plugins/dataTables/dataTables.tableTools.min.css" rel="stylesheet">
@endsection
@section('title')
  Detail Penjualan
@stop

@section('content')  
    <div class="row wrapper border-bottom white-bg page-heading">	
        <div class="col-sm-4">
            <h2>Detail Penjualan</h2>
            <ol class="breadcrumb">
                <li class="active">
                    <a href="{{route('orders.index')}}">Penjualan</a>
                </li>                
            </ol>
        </div>
        
    </div>   
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="ibox-content p-xl">
                            <div class="row">
                                <div class="col-sm-6">                                    
                                    <address>
                                        <strong>{{$order->kasir->store->name}}</strong><br>
                                        <i class="fa fa-map-marker"></i> {{$order->kasir->store->address}}<br>
                                        <i class="fa fa-phone"></i> {{$order->kasir->store->phone}}
                                    </address>
                                </div>

                                <div class="col-sm-6 text-right">                                    
                                    <h4 class="text-navy">NO. {{$order->id}}</h4>
                                    <span class="label label-{{$order->statusLabel()}}">{{$order->status}}</span><br><br>
                                    <address>
                                    kepada:<strong>{{$order->customer->name}}</strong><br>
                                        <i class="fa fa-map-marker"></i> {{$order->kasir->store->address}}<br>
                                        <i class="fa fa-map-phone"></i> {{$order->kasir->store->phone}}
                                    </address>
                                    <p>
                                        <span><strong>Tanggal</strong> {{$order->created_at->format('d M Y')}}</span><br>
                                    </p>
                                </div>
                            </div>

                            <div class="table-responsive m-t">
                                <table class="table invoice-table">
                                    <thead>
                                    <tr>
                                        <th>Barang</th>
                                        <th>Qty</th>
                                        <th>Harga Satuan</th>                                        
                                        <th>Subtotal</th>
                                    </tr>
                                    </thead>
                                    <tbody>                                    
                                    @foreach($order->items as $item)
                                    <tr>                                        
                                        <td><strong>{{$item->product->name}}</strong></td>
                                        <td>{{$item->qty}}</td>
                                        <td>{{toRp($item->price)}}</td>
                                        <td>{{toRp($item->price * $item->qty)}}</td>                                        
                                    </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div><!-- /table-responsive -->

                            <table class="table invoice-total">
                                <tbody>
                                <tr>
                                    <td><strong>TOTAL BARANG :</strong></td>
                                    <td>{{$order->total_qty}} PCS</td>
                                </tr>
                                <tr>
                                    <td><strong>TOTAL HARGA :</strong></td>
                                    <td>{{toRp($order->total_price)}}</td>
                                </tr>

                                </tbody>
                            </table>

                            <div class="text-right"> <a href="{{route('order.print',$order)}}" class="btn btn-primary"><i class="fa fa-print"></i> Print</a></div>
                        </div>
	</div>
@stop

@section('footer')   

<script>
        $(document).ready(function() {
            
        });        
    </script>
@endsection
