@extends('layouts.kasir.master')
@section('header')
@stop
@section('content')

<div class="row">
            <div class="col-lg-8">
                <div class="wrapper wrapper-content animated fadeInRight">
                	<div class="ibox-title">
                		<h3>Detail Penjualan</h3>
                	</div>
                   
                    <div class="ibox-content p-xl">
                            <div class="row">
                                <div class="col-sm-6">                                    
                                    <address>
                                        <strong>{{getSetting('company_name')}}</strong><br>
                                        {{$order->store->name}}<br>
                                        {{$order->store->address}}<br>
                                        <abbr title="Phone"></abbr> {{$order->store->phone}}
                                    </address>
                                </div>

                                <div class="col-sm-6 text-right">
                                    <address>
                                        <strong>{{$order->customer->name}}</strong><br>
                                        <abbr title="Phone"></abbr> {{$order->customer->phone}}
                                    </address>
                                    <p>
                                        
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
                                    
                                    
                                    @foreach($order->items as $item)
                                    <tr>
                                        <td><div><strong>{{$item->product->name}}</strong></div></td>
                                        <td>{{$item->qty}}</td>
                                        <td>{{toRp($item->price)}}</td>
                                        <td>{{toRp($item->qty * $item->price)}}</td>                                        
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

                                 <tr>
                                    <td><strong>TOTAL BAYAR :</strong></td>
                                    <td>{{toRp($order->pembayaran->sum('nominal'))}}</td>
                                </tr>
                                </tbody>
                            </table>                            
                        </div>
                 
                </div>
            </div>

            <div class="col-lg-4">
            	<div class="wrapper wrapper-content animated fadeInRight">
            		<div class="ibox-title">
            		<h3>Pembayaran Hutang</h3>
            		</div>
                    
                    <div class="ibox-content">
                        <h2 class="text-center">SISA HUTANG</h2>
                        <h3 class="text-center" style="background-color: #ec9613; padding:10px 5px; color: #fff;">{{toRp($order->sisaHutang())}}</h3>
                        
            			{!!Form::open(['route' =>'kasir.post.bayar.hutang.penjualan'])!!}                            
                            <input type="hidden" name="order_id" value="{{$order->id}}">
                            <div class='form-group{{$errors->has('nominal') ? ' has-error' : ''}}'>
			                    {!!Form::label('nominal','Nominal Pembayaran',['class' => 'control-label'])!!}
			                    
			                    {!!Form::text('nominal',old('nominal'),['class' => 'uang form-control'])!!}
			                  </div>

			                <div class="form-group">
								<input type="submit" value="Selesai" class="btn btn-lg btn-primary bg-info">
							</div>
            			{!!Form::close()!!}
            			
            		</div>
            	</div>
            </div>
        </div>
@stop

@section('footer')
<script src="{{url('assets/backend')}}/js/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js"></script>
	<script>
		$(document).ready(function(){
	        $('.uang').inputmask({
	          'alias': 'numeric', 
	          'radixPoint': ',',
	          'groupSeparator': '.',
	          'autoGroup': true,
	          'digits': 0,
	          'digitsOptional': false,
	          'prefix': 'Rp ',
	          'placeholder': '0',
	          'removeMaskOnSubmit':true,
	          'rightAlign': false
	        });	
		});
	</script>
@stop
