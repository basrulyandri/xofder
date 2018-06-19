@extends('layouts.kasir.master')
@section('header')
	
@stop
@section('content')
<div class="row">
            <div class="col-lg-12">
                <div class="wrapper wrapper-content animated fadeInRight">
                    <div class="ibox-content p-xl">
                            <div class="row">
                                <div class="col-sm-6">                                    
                                    <address>
                                        <strong>RedFox Store</strong><br>
                                        Pasar Tanah ABang<br>
                                        Blok F<br>
                                        <abbr title="Phone"></abbr> 021- 3728181
                                    </address>
                                </div>

                                <div class="col-sm-6 text-right">
                                    <address>
                                        <strong>{{$order->customer->name}}</strong><br>
                                        <abbr title="Phone"></abbr> {{$order->customer->phone}}
                                    </address>
                                    <p>
                                        <span>{{$order->created_at->format('d M Y')}}</span>
                                    </p>
                                    <p>
                                        <span><strong>No Order</strong> {{$order->id}}</span>
                                    </p>
                                    <p>
                                        <span><strong>Status</strong>                                         
                                            <span class="label @if($order->status == 'lunas') label-primary @else label-danger @endif">{{strtoupper($order->status)}}</span>
                                        </span>
                                    </p>
                                </div>
                            </div>

                            <div class="table-responsive m-t">
                                <table class="table invoice-table">
                                    <thead>
                                    <tr>
                                        <th>BARANG</th>
                                        <th>QTY</th>                                        
										<th>HARGA SATUAN</th>
										<th>SUBTOTAL</th>										
                                    </tr>
                                    </thead>
                                    <tbody>
                                    
                                    @foreach(unserialize($order->cart_items)->items as $key => $item)
                                    
                                    <tr>
                                        <td><div><strong>{{$item['item']->name}}</strong></div></td>
                                        <td>{{$item['qty']}}</td>
                                        <td>{{toRp($item['price'])}}</td>
                                        <td>{{toRp($item['qty'] * $item['price'])}}</td>                                        
                                    </tr>                                    
									@endforeach
                                    </tbody>
                                </table>
                            </div><!-- /table-responsive -->
							
                            <table class="table invoice-total">
                                <tbody>                                
                                <tr>
                                    <td><strong>TOTAL BARANG :</strong></td>
                                    <td>{{unserialize($order->cart_items)->totalQty}} PCS</td>
                                </tr>
                                <tr>
                                    <td><strong>TOTAL HARGA :</strong></td>
                                    <td>{{toRp(unserialize($order->cart_items)->totalPrice)}}</td>
                                </tr>
                                <tr>
                                    <td><strong>BAYAR :</strong></td>
                                    <td>{{toRp($order->pembayaran->sum('nominal'))}}</td>
                                </tr>
                                 <tr>
                                    <td><strong>HUTANG :</strong></td>
                                    <td>{{toRp($order->total_price - $order->pembayaran->sum('nominal'))}}</td>
                                </tr>
                                
                                </tbody>
                            </table>
                            <div class="text-right">
                                <a href="{{route('order.print',$order)}}" class="btn btn-primary"><i class="fa fa-print"></i> Print</a>
                            </div>                            
                        </div>
                </div>
            </div>
        </div>
@stop